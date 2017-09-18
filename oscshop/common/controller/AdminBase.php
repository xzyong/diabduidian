<?php
/**
 * Waynes电子商务系统
 *
 * ==========================================================================
 * @link      http://www.waynes-tech.com
 * @copyright Copyright (c) 2015-2016 深圳市韦恩斯科技有限公司

 * ==========================================================================
 *
 * @author    深圳韦恩斯科技有限公司
 *
 */
namespace osc\common\controller;
use think\Db;
use osc\admin\service\User;
class AdminBase extends Base{	
	
	protected $user;
	
	protected function _initialize() {
		parent::_initialize();

		define('UID',User::is_login());

        if(!UID){
			$this->redirect('admin/Login/login');
        }
		//统一 AdminBase 跳转模板
		config('dispatch_error_tmpl',APP_PATH.'common/view/public/error.tpl');
		config('dispatch_success_tmpl',APP_PATH.'common/view/public/success.tpl');
		
		$this->get_menu();
		
        //权限判断  
        if(session('user_auth.username')!=config('administrator')){//超级管理员不需要验证        
	        
			$auth = new \auth\Auth();
			
			if (!$auth->check(request()->module().'/'.to_under_score(request()->controller()).'/'.request()->action(), session('user_auth.uid'))) {
								
				$this->error('没有权限！');
			}
		}


	}

	public function get_menu(){

		if(session('user_auth.username')!=config('administrator')){
			$this->assign('admin_menu',$this->get_auth_menu());
		}else{
			$this->assign('admin_menu',$this->get_admin_menu());
		}

	}

	public function get_admin_menu(){

		$menu=Db::query('select * from '.config('database.prefix')."menu  where type='nav' and status=1 order by sort_order");

		$parent_menu=list_to_tree($menu,'id','pid','children',0);

		return $parent_menu;
	}

	public function get_auth_menu(){

		$menu=Db::query('select m.* from '.config('database.prefix').'auth_rule ar,'.config('database.prefix')."menu m where m.id=ar.menu_id and m.type='nav' and m.status=1 and ar.group_id=".session('user_auth.group_id').' order by m.sort_order');

		$parent_menu=list_to_tree($menu,'id','pid','children',0);

		return $parent_menu;
	}
	
	//用于单表插入操作
	public function single_table_insert($table_name,$user_action){
				
			$data=input('post.');
			$result = $this->validate($data,$table_name);
			if($result!==true){
				return ['error'=>$result];
			}			
			$id=Db::name($table_name)->insert($data,false,true);			
			if($id){
				User::get_logined_user()->storage_user_action($user_action);
				return ['success'=>'新增成功','action'=>'add'];				
			}else{			
				return ['error'=>'新增失败'];
			}
		
	}
	//用于单表更新操作
	public function single_table_update($table_name,$user_action){
				
			$data=input('post.');
			$result = $this->validate($data,$table_name);			
			if($result!==true){
				return ['error'=>$result];
			}

			$r=Db::name($table_name)->update($data,false,true);			
			if($r){
				User::get_logined_user()->storage_user_action($user_action);
				return ['success'=>'更新成功','action'=>'edit'];
			}else{			
				return ['error'=>'更新失败'];
			}
		
	}
	//用于单表删除操作
	public function single_table_delete($table_name,$user_action){
		
		$r=Db::name($table_name)->delete((int)input('id'));	
		
		if($r){
			User::get_logined_user()->storage_user_action($user_action);
			return ['success'=>'删除成功','action'=>'delete'];
		}
		
	}
	
}
