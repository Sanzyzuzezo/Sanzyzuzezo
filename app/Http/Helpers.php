<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LogSystem;
use App\Models\UserGroupPermission;
use App\Models\Module;
use App\Models\ModuleAccess;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;

function asset_administrator($url)
{
    return asset('administrator/' . $url);
}

function asset_frontpage($url)
{
    return asset('frontpage-schoko/' . $url);
}

function asset_landing_page($url)
{
    return asset('landing_page/' . $url);
}

function upload_path($type = '', $file = '')
{
    switch ($type) {
        case 'product':
            $target_folder = 'products';
            break;
        case 'category':
            $target_folder = 'categories';
            break;
        case 'brand':
            $target_folder = 'brands';
            break;
        case 'customer':
            $target_folder = 'customers';
            break;
        case 'logo':
            $target_folder = 'settings';
            break;
        case 'favicon':
            $target_folder = 'settings';
            break;
        case 'page':
            $target_folder = 'pages';
            break;
        case 'banner':
            $target_folder = 'banners';
            break;
        case 'news':
            $target_folder = 'news';
            break;
        case 'payment_confirmation':
            $target_folder = 'payment_confirmations';
            break;
        case 'store':
            $target_folder = 'stores';
            break;
        case 'article':
            $target_folder = 'articles';
            break;
        case 'profile':
            $target_folder = 'profiles';
            break;
        case 'invoice_sales':
            $target_folder = 'invoice_sales';
            break;
        case 'settings':
            $target_folder = 'settings';
            break;
        case 'customer':
            $target_folder = 'customers';
            break;
        default:
            $target_folder = '';
            break;
    }

    return Str::finish('administrator/assets/media/' . $target_folder, '/') . $file;
}

function img_src($image = '', $img_type = '')
{
    $file_notfound = 'media/notfound.jpg';

    if (filter_var($image, FILTER_VALIDATE_URL)) {
        return $image;
    } else {
        switch ($img_type) {
            case 'log_absen' :
                $folder = '/log_absen/';
                break;
            case 'product':
                $folder = '/products/';
                break;
            case 'brand':
                $folder = '/brands/';
                break;
            case 'category':
                $folder = '/categories/';
                break;
            case 'logo':
                $folder = '/settings/';
                break;
            case 'favicon':
                $folder = '/settings/';
                break;
            case 'news':
                $folder = '/news/';
                break;
            case 'pages':
                $folder = '/pages/';
                break;
            case 'payment_confirmation':
                $folder = '/payment_confirmations/';
                break;
            case 'payment_methods':
                $folder = '/payment_methods/';
                break;
            case 'profile':
                $folder = '/profile/';
                break;
            case 'invoice_sales':
                $folder = '/invoice_sales/';
                break;
            case 'settings':
                $folder = '/settings/';
                break;
            case 'customer':
                $folder = '/customers/';
                break;
            default:
                $folder = '/';
                break;
        }
        // $file = 'administrator/assets/media' . $folder . $image;
        $file = 'administrator/assets/media' . $folder . $image;
        //echo $file;
        if ($image === true) {
            return url('media' . $folder);
        } elseif (file_exists($file) && !is_dir($file)) {
            return url($file);
        } elseif (file_exists($file_notfound)) {
            return url($file_notfound);
        } else {
            // return 'https://t4.ftcdn.net/jpg/04/99/93/31/360_F_499933117_ZAUBfv3P1HEOsZDrnkbNCt4jc3AodArl.jpg';
            return 'https://media.istockphoto.com/id/1354776457/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=w3OW0wX3LyiFRuDHo9A32Q0IUMtD4yjXEvQlqyYk9O4=';
            // return 'https://t3.ftcdn.net/jpg/05/52/37/18/360_F_552371867_LkVmqMEChRhMMHDQ2drOS8cwhAWehgVc.jpg';
            // return 'https://t4.ftcdn.net/jpg/04/00/24/31/360_F_400243185_BOxON3h9avMUX10RsDkt3pJ8iQx72kS3.jpg';
        }
    }
}

function createLog($module, $action, $data_id)
{
    $log['ip_address'] 	= request()->ip();
    $log['user_id'] 	= auth()->check() ? auth()->user()->id : 1;
    $log['module'] 		= $module;
    $log['action'] 		= $action;
    $log['data_id'] 	= $data_id;
    $log['device'] 		= '';
    $log['data'] 		= '';
    $log['created_at'] 	= date('Y-m-d H:i:s');
    LogSystem::create($log);
}

function getCompanyId()
{
    $data_user = User::find(auth()->user()->id);
    return $data_user->company_id;
}

function isAllowed($modul, $modul_akses)
{
	$data_user = User::find(auth()->user()->id);
	$grup_pengguna_id = $data_user->user_group_id;
	$permission = getPermissionGroup($grup_pengguna_id);
	if ($grup_pengguna_id == 0) {
		return TRUE;
	} else {
		if ($permission[$grup_pengguna_id][$modul][$modul_akses] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

function getDefaultPermission()
{
	$query = ModuleAccess::select(DB::raw("modules_access.*,user_group_permissions.user_group_id,user_group_permissions.status"))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id');
			}
		);
	$data_akses = $query->get();
	$data_grup_pengguna = UserGroup::all();
	$permission = array();
	foreach ($data_grup_pengguna as $val) {
		foreach ($data_akses as $row) {
			$permission[$val->id][$row->module_id][$row->id] = 0;
		}
	}
	return $permission;
}

function getPermissionGroup($user_group_id)
{

	$data_akses = ModuleAccess::select(DB::raw('modules.identifiers as module_identifiers,modules_access.*,user_group_permissions.user_group_id,user_group_permissions.status'))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) use ($user_group_id) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id')->where("user_group_permissions.user_group_id", "=", $user_group_id);
			}
		)
		->leftJoin(DB::raw("modules"), "modules.id", "=", "modules_access.module_id")
		->get();
	$permission = [];
	$index = 0;

	foreach ($data_akses as $row) {
		if ($row->status == "") {
			$status = 0;
		} else {
			$status = $row->status;
		}
		$permission[$user_group_id][$row->module_identifiers][$row->identifiers] = $status;
	}
	$index++;

	return $permission;
}


function getPermissionGroup2($x)
{

	$data_akses = ModuleAccess::select(DB::raw('mmodules.identifiers as module_identifiers,modules_access.*,user_group_permissions.user_group_id,user_group_permissions.status'))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) use ($x) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id')->where("user_group_permissions.user_group_id", "=", $x);
			}
		)
		->leftJoin(DB::raw("modules"), "modules.id", "=", "modules_access.module_id")
		->get();


        // dd($x);



	$permission = [];
	$index = 0;

	foreach ($data_akses as $row) {
		if ($row->status == "") {
			$status = 0;
		} else {
			$status = $row->status;
		}
		$permission[$x][$row->module_identifiers][$row->identifiers] = $status;
	}
	$index++;

	return $permission;
}

function getPermissionModuleGroup()
{
	$data_user = User::find(auth()->user()->id);
	$grup_pengguna_id = $data_user->user_group_id;
	$data_akses = ModuleAccess::select(DB::raw('modules.identifiers as module_identifiers, COUNT(user_group_permissions.id) as permission_given'))
		->leftJoin(
			DB::raw("user_group_permissions"),
			function ($join) use ($grup_pengguna_id) {
				$join->on('user_group_permissions.module_access_id', '=', 'modules_access.id')->where("user_group_permissions.user_group_id", "=", $grup_pengguna_id)->where("user_group_permissions.status", 1);
			}
		)
		->leftJoin(DB::raw("modules"), "modules.id", "=", "modules_access.module_id")
		->groupBy("modules.id")
		->get();

	$permission = [];
	$index = 0;

	foreach ($data_akses as $row) {
		if ($row->permission_given > 0) {
			$status = TRUE;
		} else {
			$status = FALSE;
		}
		$permission[$row->module_identifiers] = $status;
	}
	$index++;

	return $permission;
}

function showModule($module, $permission_module)
{
	$data_user = User::find(auth()->user()->id);
	$grup_pengguna_id = $data_user->user_group_id;
	if ($grup_pengguna_id == 0) {
		return TRUE;
	} else {
		if (array_key_exists($module, $permission_module)) {
			return $permission_module[$module];
		} else {
			return FALSE;
		}
	}
}
