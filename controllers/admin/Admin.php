<?php

class Admin extends VirtualDir
{
	
	public static $pages;
	
	public function __construct()
	{	
		Admin::$pages = array
		(
			array(
			'title'    => 'Dashboard', 
			'basePath' => '', 
			'rewrite'  => '/', 
			'module'   => 'Adm_Index',
			'addnew'   => false, 
			'icon'     => 'home'
			),
			
			array(
			'title'    => 'Media', 
			'basePath' => '/media', 
			'rewrite'  => '/media',
			'module'   => 'Adm_Media',
			'addnew'   => false, 
			'icon'     => 'image'
			),
			
			
			
			array(
            'title'    => 'Slider', 
            'basePath' => '/slider', 
            'addnew'   => true, 
            'rewrite'  => '/slider(|/(?<task>(edit|new)))', 
            'module'   => 'Adm_Sliders',
            'contentType'=>'menu',
            'icon'     => 'layers',
             'group'	   => array( 
            				array(
								'title'    => 'Add New',
								'basePath' => '/slider/new',
								'icon'     => ''
							)
							
						)
            ),
            
			'-',
			array(
            'title'    => 'Products', 
            'basePath' => '/products', 
            'addnew'   => true, 
            'rewrite'  => '/products(|/(?<task>(edit|new)))', 
            'module'   => 'Adm_Products',
            'contentType'=>'menu',
            'icon'     => 'receipt',
            "group"	   => array(
				            array(
										'title'    => 'Add New',
										'basePath' => '/products/new',
										'addnew'   => false,
										'rewrite'  => '/products(|/(?<task>(edit|new)))',
										'module'   => 'Adm_Products',
										'icon'     => ''
										)
							
							
				)
            ),
            
				// array(
            // 'title'    => 'Page', 
            // 'basePath' => '/page', 
            // 'addnew'   => true, 
            // 'rewrite'  => '/page(|/(?<task>(edit)))', 
            // 'module'   => 'Adm_Pages',
            // 'contentType'=>'page',
            // 'icon'     => 'layers',
             // 'group'	   => array( 
            				// array(
								// 'title'    => 'About Us',
								// 'basePath' => '/page/edit?id=9',
								// 'icon'     => ''
							// )
// 							
						// )
            // ),
			'-',
			array(
			'title'    => 'About Page', 
			'basePath' => '/setting/aboutus', 
			'rewrite'  => '/setting/aboutus', 
			'module'   => 'Adm_MetaAbout',
			'addnew'   => false, 
			'icon'     => 'cog'
			),
			
			array(
			'title'    => 'Philosophy Page', 
			'basePath' => '/setting/philosophy', 
			'rewrite'  => '/setting/philosophy', 
			'module'   => 'Adm_MetaPhilosophy',
			'addnew'   => false, 
			'icon'     => 'cog'
			),
			
			array(
			'title'    => 'Settings', 
			'basePath' => '/setting/general', 
			'rewrite'  => '/setting/general', 
			'module'   => 'Adm_Settings',
			'addnew'   => false, 
			'icon'     => 'cog'
			),
			
				array(
			'title'    => 'Users', 
			'basePath' => '/users', 
			'addNew'   => array('User','/pages/new'), 
			'rewrite'  => '/users(|/(?<task>(edit|new)))', 
			'module'   => 'Adm_Users',
			'addnew'   => true, 
			'icon'     => 'users'
			),
		);
	}
	
	public function pathRewrites(& $rewrites)
	{
		//$rewrites['/'] = 'Adm_Index';
		$rewrites["/(?<pathName>(login|logout))(|(/(?<task>(forgot|reset))))"]= "Adm_Login";
		$rewrites['/media/upload'] = 'Adm_MediaUpload';
		
	//	$rewrites['/setting/general'] = "Adm_Settings";
		
		foreach(Admin::$pages as $value)
		{
			if(is_array($value))
			{
				$rewrites[ $value['rewrite']] = $value['module'];
			}
		}
	}
	
	public static function getMenus()
	{
		
	}

}

?>
