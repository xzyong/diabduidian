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

namespace osc\index\controller;

use osc\common\controller\HomeBase;
use osc\common\model\Goods as GoodsModel;
use think\Db;
use think\Request;

class Exproduct extends HomeBase
{

    public function search(){
		//搜索
        if (input('param.search') && input('param.name')) {
            $name = input('name');
            $query=[];
            $query['name']=$name;
            $query['search']=input('search') ;
            $list = Db::name('goods')
                ->where('name', 'like', "%$name%")
                ->where(['status'=>1,'is_points_goods'=> 1])
                ->paginate(8,false,['query'=>$query]);
			//dump(Db::name('goods')->getLastSql());die;
            $this->assign('cate', '');
            $this->assign('father', '');
            $this->assign('id', input('param.id'));
            $this->assign('mun', count($list));
            $this->assign('page', $list->render());
            $this->assign('empty', '<div class="list-content" style="width: 500px; height: 500px">暂时没有该产品的信息</div>');
            $this->assign('goodlist', $list);	//				1
            $this->assign('ptitle', '混合搜索');
            $this->assign('SEO', ['title' => '兑换商品列表 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);
            return $this->fetch();
        }
    }

    public function index()
    {

        if (request()->isPost()) {
			//echo(input('post.oid'));die;
            if (input('param.search') && input('param.name')) {
                $name = input('name');
                $query['name']=$name;
                $list = Db::name('goods')
                    ->where('name', 'like', "%$name%")
                    ->where(['status'=>1,'is_points_goods'=> 1])
                    ->paginate(8,true,$query);
                $this->assign('cate', '');
                $this->assign('father', '');

                $this->assign('ptitle', '混合搜索');
                $this->assign('SEO', ['title' => '兑换商品列表 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);
            } else {
                $id = input('param.id');
                switch ($id) {
                    case 0:
                        switch (input('param.oid')) {
                            case 3:
                                $lis = osc_goods()->moretickect('in', 'viewed desc', 8);
                                break;
                            case 4:
                                $lis = osc_goods()->moretickect('in', 'viewed', 8);
                                break;
                        };
                        break;
                    case 1:
                        switch (input('param.oid')) {
                            case 1:
                                $lis = osc_goods()->moretickect('not in', 'pay_points desc', 8);
                                break;
                            case 2:
                                $lis = osc_goods()->moretickect('not in', 'pay_points', 8);
                                break;
                            case 3:
                                $lis = osc_goods()->moretickect('not in', 'viewed desc', 8);
                                break;
                            case 4:
                                $lis = osc_goods()->moretickect('not in', 'viewed', 8);
                                break;
                        };
                        break;
                    default:
                        $goods = osc_goods()->get_category_goods(input('param.id'));
                        if (empty($goods)) {
                            switch (input('param.oid')) {
                                case 1:

                                    $lis = osc_goods()->getGoodslist(['status' => 1, 'category_pid' => input('param.id')], 'pay_points desc', 8);
                                    break;
                                case 2:
                                    $lis = osc_goods()->getGoodslist(['status' => 1, 'category_id' => input('param.id')], 'pay_points', 8);
                                    break;
                                case 3:
                                    $lis = osc_goods()->getGoodslist(['status' => 1, 'category_id' => input('param.id')], 'viewed desc', 8);
                                    break;
                                case 4:
                                    $lis = osc_goods()->getGoodslist(['status' => 1, 'category_id' => input('param.id')], 'viewed', 8);
                                    break;
                            }
                        } else {

                            $li = [];
                            foreach ($goods as $key => $val) {
                                $li[$key] = $val['id'];

                            }

                            switch (input('param.oid')) {
                                case 1:
                                    $lis = osc_goods()->getGoodslists(['status' => 1, 'is_points_goods' => 1], 'pay_points desc', 8, $li);
									//dump($lis);die;
                                    break;
                                case 2:
                                    $lis = osc_goods()->getGoodslists(['status' => 1, 'is_points_goods' => 1], 'pay_points', 8, $li);
                                    break;
                                case 3:
                                    $lis = osc_goods()->getGoodslists(['status' => 1, 'is_points_goods' => 1], 'viewed desc', 8, $li);
                                    break;
                                case 4:
                                    $lis = osc_goods()->getGoodslists(['status' => 1, 'is_points_goods' => 1], 'viewed', 8, $li);
                                    break;
                            }
                        }
					}
                }

                $list = [];
                foreach ($lis as $k => $v) {
                    $v['image'] = resize($v['image'], 210, 210);
                    $v['url'] = url('Exproduct/details', 'id=' . $v['goods_id']);
                    $list[$k] = $v;

                }
                //return dump($list);//$list;
				
            }
			
			
        if(request()->isGet()){
			//echo(input('id'));die;
            switch (input('param.id')) {
                case 0:
                    $list = osc_goods()->moretickect('in', 'goods_id desc', 8);
					//?查询符合条件的商品
                    $this->assign('cate', '');
                    $this->assign('father', '');
                    $this->assign('ptitle', '单券专区');
                    $this->assign('SEO', ['title' => '单券专区 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);
					//dump(Db::name('goods')->getLastSql());die;
                    break;
                case 1:
                    $list = osc_goods()->moretickect('not in', 'goods_id desc', 8);
								//dump(Db::name('goods')->getLastSql());
                    $this->assign('father', '');
                    $this->assign('cate', '');
                    $this->assign('SEO', ['title' => '多券专区 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);
                    $this->assign('ptitle', '多券专区');
                    break;
                default:
                    $goods = osc_goods()->get_category_goods(input('param.id'));
					//dump($goods);die;
                    $father = osc_goods()->get_category_father(input('param.id'));
                    $title = Db::name('category')->where('id', input('param.id'))->find();
                    $this->assign('SEO', ['title' => '兑换商品列表 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);
                    if (empty($goods)) {
                        $list = osc_goods()->getGoodslist(['status' => 1, 'category_pid' => input('param.id')], 'goods_id desc', 8);
						
                        $this->assign('ptitle', $title['name']);
                        $this->assign('father', $father);
                        $this->assign('cate', '');
                    } else {
                        $lis = [];
                        foreach ($goods as $key => $val) {
                            $lis[$key] = $val['id'];

                        }
						$list = osc_goods()->getGoodslists(['status' => 1, 'is_points_goods' => 1], 'goods_id desc', 8, $lis);
						//dump(Db::name('goods')->getLastSql());die;
						/* $getTree=osc_goods()->getTree();
						$is='1';$pad='8';
						$list=osc_goods()->goods_category_search($lis,$getTree,$is,$pad); */
                        $this->assign('ptitle', $title['name']);

                        $this->assign('cate', $goods);
                        $this->assign('father', $father);
                    }


            }
        }


		
		//dump(osc_goods()->getLastSql());die;
        $this->assign('id', input('param.id'));
        $this->assign('mun', count($list));
		//合计
        $this->assign('page', $list->render());
		//分页
        $this->assign('empty', '<div class="list-content" style="width: 500px; height: 500px">暂时没有该产品的信息</div>');
		//错误信息
        $this->assign('goodlist', $list);
			//dump($list);die;
        return $this->fetch();
    }

    //入会商品列表
    public function me_index()
    {
        if (request()->isPost()) {
				
            if(input('post.search')&&input('post.name')){
				//判断搜索
                $name = input('post.name');
                $list= Db::name('goods')
                    ->where('name', 'like', "%$name%")
                    ->where(['status'=>1,'is_points_goods'=>0])
                    ->paginate(8);

                $this->assign('cate', '');
                $this->assign('father', '');

                $this->assign('ptitle', '混合搜索');
                $this->assign('SEO', ['title' => '兑换商品列表 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);
            }else{
                if (input('param.id') && input('param.cate_id')) {
                    switch (input('param.oid')) {
                        case 1:
                            $lis = osc_goods()->getGoodslist(['status' => 1, 'category_pid' => input('param.cate_id'),], 'origin_price desc', 2);
                            break;
                        case 2:
                            $lis = osc_goods()->getGoodslist(['status' => 1, 'category_pid' => input('param.cate_id'),], 'origin_price', 8);
                            break;
                        case 3:
                            $lis = osc_goods()->getGoodslist(['status' => 1, 'category_pid' => input('param.cate_id'),], 'viewed desc', 8);
                            break;
                        case 4:
                            $lis = osc_goods()->getGoodslist(['status' => 1, 'category_pid' => input('param.cate_id'),], 'viewed', 8);
                            break;
                    }
                } else {
                    switch (input('param.oid')) {
                        case 1:

                            $lis = osc_goods()->getGoodslist(['category_id' => input('param.id'), 'status' => 1,], 'origin_price desc', 2);
                            break;
                        case 2:
                            $lis = osc_goods()->getGoodslist(['a.status' => 1, 'category_id' => input('param.id'),], 'origin_price', 8);
                            break;
                        case 3:
                            $lis = osc_goods()->getGoodslist(['a.status' => 1, 'category_id' => input('param.id'),], 'viewed desc', 8);
                            break;
                        case 4:
                            $lis = osc_goods()->getGoodslist(['a.status' => 1, 'category_id' => input('param.id'),], 'viewed', 8);
                            break;
                    }
                }


                $list = [];
                foreach ($lis as $k => $v) {
                    $v['image'] = resize($v['image'], 210, 210);
                    $v['url'] = url('Goods/index', 'id=' . $v['goods_id']);
                    $list[$k] = $v;

                }
                return $list;
            }

        }

        if (input('param.id') && input('param.cate_id')) {
            $title = Db::name('category')->where('id', input('param.id'))->find();
            $list = osc_goods()->getGoodslist(['category_pid' => input('param.cate_id'), 'status' => 1,], 'goods_id desc', 8);
            $this->assign('cate','');
            $father = osc_goods()->get_category_father(input('param.id'));
            $this->assign('father', $father);
            $this->assign('ptitle', $title['name']);
        }elseif (input('param.id') && !input('param.cate_id')){
			$list=Db::name('goods')->where('is_points_goods','0')->where('status',1)->order('goods_id desc')->paginate(8);
            $father = osc_goods()->get_category_father(input('param.id'));
            $this->assign('father', $father);
			$class=$this->getTree();
			foreach($class as $v){
				if($v['id']==input('param.id')){
					foreach($v['child'] as $vo){
						$cate[]=$vo;
					}
				}
			}
            $this->assign('cate', $cate);
        }
		/* $lis = array();
        foreach ($list as $key => $v) {
            if ($v['end_time'] !== NULL) {
                $lis[$key] = $v;
                if (strtotime($v['end_time']) < time()) {
                    $lis[$key]['end_time'] = 1;
                }
            }
        } */
		


//        dump($lis);die;
        $this->assign('id', input('param.id'));

        $this->assign('page', $list->render());

        $this->assign('SEO', ['title' => '入会商品列表 - ' . config('SITE_URL') . '-' . config('SITE_TITLE')]);

        $this->assign('empty', '<div class="list-content" style="width: 500px; height: 500px">非常抱歉，暂时还没有信息，如有问题请联系客服</div>');
        $this->assign('goodlist', $list);
		//入会商品
		//dump($lis);die;
        return $this->fetch();
    }

//兑换商品详情
    public function details()
    {	
		$id=input('param.id');
		$status=Db::name('goods')->where('goods_id',$id)->field('status')->find();
		//dump($status);die;
    	if($status['status']==1){
        if (!$list = osc_goods()->get_goods_info((int)input('param.id'))) {
            $this->error('商品不存在！！');
        }
        $comment=Db::name('goods_comment')->where(['goods_id'=>input('param.id'),'status'=>1])->order('id desc')->limit(2)->select();
        foreach($comment as $key=>$v){
            $comment[$key]['phone']=substr_replace($v['phone'],'*********',1,9);
        }
        $this->assign('count', Db::name('goods_comment')->where(['goods_id' => input('param.id'), 'status' => 1])->count());
        $this->assign('comment',$comment );
        $this->assign('SEO', ['title' => $list['goods']['name'] . '-' . config('SITE_URL') . '-' . config('SITE_TITLE'),
            'keywords' => $list['goods']['meta_keyword'],
            'description' => $list['goods']['meta_description']]);
        $good = GoodsModel::get((int)input('param.id'));
        $good->updateViewed();
        $this->assign('list', Db::name('goods_attribute')->alias('a')->where('a.goods_id', input('param.id'))->join('attribute_value w', 'a.attribute_value_id = w.attribute_value_id')->select());
        $this->assign('collect', Db::name('collect')->where(['uid' => member('uid'), 'goods_id' => $list['goods']['goods_id'], 'is_points_goods' => 0])->find());
        $this->assign('goods', $list['goods']);
        $this->assign('image', $list['image']);
        $this->assign('list4', Db::name('goods')->where(['is_points_goods' => 1, 'status' => 1])->order("viewed desc")->limit(4)->select());
        $this->assign('empty', '&nbsp;&nbsp;&nbsp;&nbsp;暂时还没有人评论!');
//        dump($list['goods']);die;
//            dump(resize($list['goods']['image'],100,100));die;
        return $this->fetch();
		}else{
			$this->error('非常抱歉，您访问的商品已下架，您可以查看其它商品，给您带来不便非常抱歉。');
		}
    }

//添加评论
    public function addComent()
    {
        if (request()->isAjax()) {
            $data = input('post.');
            if (!member('uid')) {
                $data['user_name'] = '游客';
            } else {
                $data['user_name'] = member('nickname');
                $data['phone'] = member('telephone');
                $data['userpic'] = member('userpic');
            }
            $data['status'] = 2;
            $data['add_time'] = date('Y-m-d,H-i-s');
            Db::name('goods_comment')->insert($data);

            return true;
        }

    }

//分类查询
	public function getTree($pid=0){
		$list=Db::name('category')->where('pid='.$pid)->select();
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['child']=$this->getTree($v['id']);
			}
			
		}
		return $list;
	}
}
