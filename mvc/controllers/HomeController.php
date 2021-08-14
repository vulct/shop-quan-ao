<?php 
/**
 * 
 */
class HomeController extends controllers
{	
	protected $product;
	protected $about;
	protected $contact;
	protected $feedback;

	public function home()
	{

		$this->product = $this->models('Home');
		$dataViews = [
			'views'=>'home',
			'pro'=>$this->product->getAllProduct(),
			'sale'=>$this->product->getProductsSale(),
			'fb'=>$this->product->getAllFB()
		];
		$this->views('layouts/master',$dataViews);
	}

	public function view_about(){
		$this->about = $this->models('Home');
		$dataViews = [
			'views' => 'about'
		];
		$this->views('layouts/master',$dataViews);
	}

	public function view_contact(){
		$this->contact = $this->models('Home');
		$dataViews = [
			'views' => 'contact'
		];
		$this->views('layouts/master',$dataViews);
	}

	public function submit(){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message= $_POST['message'];
		$this->feedback = $this->models('Home');
		$fb = $this->feedback->addFeedback($name,$email,$message);
		if ($fb){
			$this->models('Customer')->addLog("Khách hàng ".$name,'thực hiện gửi feedback thành công!');
		}
	}
}
 ?>
