<?php

namespace App\Services;

use App\Services\Service;

use App\Models\AdmUser;
use App\Models\AdmRole;
use App\Models\AdmMenu;
use App\Models\Announcement;

class AdmLoginService extends Service
{
    private $AdmUser;
    private $AdmRole;
    private $AdmMenu;
    private $Announcement;

    public function __construct()
    {
        $this->AdmUser = new AdmUser();
        $this->AdmRole = new AdmRole();
        $this->AdmMenu = new AdmMenu();
        $this->Announcement = new Announcement();
    }

    # 判斷 adm 登入
    public function isAdmLogin($login, $passwd)
    {
        # 將密碼進行加密
        $passwdEncode = $this->passwdEncode($passwd);

        # 對 adm_user 查詢
        $result = $this->AdmUser
            ->where('login', $login)
            ->where('passwd', $passwdEncode)
            ->where('status', AdmUser::STATUS_ENABLE)
            ->count();

        if (1 == $result) {
            return true;
        }
        return false;
    }

    # 取得 adm user 資料,包含可用 menu
    public function getAdmUser($login)
    {
        # 先取得 adm user 資料
        $admUser = $this->AdmUser
            ->select(
                $this->AdmUser->getTable() . '.login',
                $this->AdmUser->getTable() . '.mail_address',
                $this->AdmRole->getTable() . '.name as group',
                $this->AdmRole->getTable() . '.note as groupName',
                $this->AdmRole->getTable() . '.work_list'
            )
            ->where($this->AdmUser->getTable() . '.login', $login)
            ->join($this->AdmRole->getTable(), $this->AdmRole->getTable() . '.id', '=', $this->AdmUser->getTable() . '.role_id')
            ->first();

        # 再利用 adm user 的 work_list 取得 menu 資料
        # 主 menu
        $admMenus = $this->AdmMenu
            ->whereNull($this->AdmMenu->getTable() . '.parent_id')
            ->whereIn($this->AdmMenu->getTable() . '.id', explode(',', $admUser->work_list))
            ->orderBy($this->AdmMenu->getTable() . '.sort')
            ->get();
        # subMenu
        $admSubMenu = array();
        foreach ($admMenus as $menu) {
            $admSubMenus = $this->AdmMenu
                ->where($this->AdmMenu->getTable() . '.parent_id', $menu->getKey())
                ->whereIn($this->AdmMenu->getTable() . '.id', explode(',', $admUser->work_list))
                ->orderBy($this->AdmMenu->getTable() . '.sort')
                ->get();

            if (count($admSubMenus) > 1)
            # 有 sub
            {
                $admSubMenu[$menu->getKey()] = $admSubMenus;
            }
        }

        $admLogin = new \stdClass();
        $admLogin->user = $admUser;
        $admLogin->menu = $admMenus;
        $admLogin->subMenu = $admSubMenu;

        return $admLogin;
    }

    /**
     * 網頁列表 function
     *
     * @return void
     */
    public function admWebList()
    {
        $query = $this->Announcement
            ->where('status', '!=', 2)
            ->get();

        return $query;
    }
}
