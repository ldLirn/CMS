<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController {

	protected $article;  
	protected $article_cate;
	public function _initialize()
	{
		parent::_initialize();
		$this->article = M('article');
		$this->article_cate = M('article_cate');
	}

	public function _empty()
    {
        header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码
        $this->display("Msg:404");
    }
	/**
	 * 文章分类
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
    public function cate()
	{
		dd(I('get.qsx',0,'intval'));
		
		$data = tree($this->article_cate->order('sort asc')->select());
		$this->title = '文章分类';
		$this->assign('data',$data);
		$this->display();
	}
	/**
	 * 添加分类
	 * @return [type] [description]
	 */
	public function cate_add()
	{
		if(IS_AJAX)
		{
			$data = array(
				'pid' => I('post.pid',0,'intval'),
				'name'=> I('post.name','','htmlspecialchars'),
				'description' =>  I('post.description','','htmlspecialchars'),
				'sort'=> I('post.sort',50,'intval')
			);
			if($this->article_cate->create($data))
			{
				if($this->article_cate->add())
				{
					$this->ajaxReturn(reAjax(200,'分类添加成功'));
				}
				else
				{
					$this->ajaxReturn(reAjax(-2,'添加分类失败，请稍后重试'));
				}
			}
			else
			{
				$this->ajaxReturn(reAjax(-1,$this->article_cate->getError()));
			}
		}
		$cate = tree($this->article_cate->order('sort asc')->select());
		$this->title = '添加分类';
		$this->assign('cate',$cate);
		$this->display();
	}
	/**
	 * 修改分类
	 * @return [type] [description]
	 */
	public function cate_edit()
	{
		if(IS_AJAX)
		{
			$data = array(
				'id'  => I('post.id',0,'intval'),
				'pid' => I('post.pid',0,'intval'),
				'name'=> I('post.name','','htmlspecialchars'),
				'description' =>  I('post.description','','htmlspecialchars'),
				'sort'=> I('post.sort',50,'intval')
			);
			if($data['id']==0)
			{
				$this->ajaxReturn(reAjax(-4,'不存在的id'));
			}
			if($this->article_cate->create($data))
			{
				if($this->article_cate->save())
				{
					$this->ajaxReturn(reAjax(200,'分类修改成功'));
				}
				else
				{
					$this->ajaxReturn(reAjax(-2,'修改分类失败，请稍后重试'));
				}
			}
			else
			{
				$this->ajaxReturn(reAjax(-1,$this->article_cate->getError()));
			}
		}
		$id = I('get.id',0,'intval');
		if($id==0)
		{
			$this->ajaxReturn(reAjax(-3,'不存在的id'));
		}
		$data = $this->article_cate->find($id);
		$cate = tree($this->article_cate->order('sort asc')->select());
		$this->title = '修改分类';
		$this->assign('cate',$cate);
		$this->assign('data',$data);
		$this->display();
	}
	/**
	 * 删除分类
	 */
	public function cate_delete()
	{
		$this->title = '删除分类';
		$this->display();
	}
	/**
	 * 文章列表
	 * @return [type] [description]
	 */
	public function lists()
	{
		$this->title = '文章列表';
		$this->display();
	}
	/**
	 * 添加文章
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function article_add()
	{
		$this->title = '添加文章';
		$this->display();
	}

	/**
	 * 修改文章
	 * @return [type] [description]
	 */
	public function article_edit()
	{
		$this->title = '修改文章';
		$this->display();
	}

	/**
	 * 删除文章
	 * @return [type] [description]
	 */
	public function article_delete()
	{
		$this->title = '删除文章';
		$this->display();
	}
}