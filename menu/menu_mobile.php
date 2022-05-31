<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
        <title>Sistema Monitoreo y Evaluación ACH</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet"  href="<?php echo $_SESSION["scriptcase"]["menu"]["glo_nm_path_prod"]; ?>/third/jquery.mobile/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet"  href="<?php echo $this->url_css; ?>Sc8_BlueWood/Sc8_BlueWood_menuMobile.css" />
        <link rel="stylesheet"  href="<?php echo $this->url_css; ?>Sc8_BlueWood/Sc8_BlueWood_menuMobile<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" />
        <link rel="stylesheet" href="<?php echo $_SESSION['scriptcase']['menu']['glo_nm_path_prod']; ?>/third/font-awesome/css/all.min.css" type="text/css" media="screen" />
        <script src="<?php echo $_SESSION["scriptcase"]["menu"]["glo_nm_path_prod"]; ?>/third/jquery.mobile/jquery.js"></script>
        <script type="text/javascript">
            $(document).bind("mobileinit", function() {
                $.mobile.page.prototype.options.backBtnText = "<?php echo $this->Nm_lang["lang_btns_prev"]; ?>";
                $.mobile.page.prototype.options.addBackBtn = true;
            });
        </script>
        <script src="<?php echo $_SESSION["scriptcase"]["menu"]["glo_nm_path_prod"]; ?>/third/jquery.mobile/jquery.mobile-1.2.0.min.js"></script>
    <style>
    <?php
    if(isset($menu_menuData["data"]) && is_array($menu_menuData["data"]) && !empty($menu_menuData["data"]))
    {
        foreach($menu_menuData["data"] as $arr_item)
        {
            if(isset($arr_item["icon_color"]) && !empty($arr_item["icon_color"]))
            {
                echo "   #" . $arr_item["id"] . " .icon_fa{ color: ". $arr_item["icon_color"] ."  !important}\r\n";
            }
            if(isset($arr_item["icon_color_hover"]) && !empty($arr_item["icon_color_hover"]))
            {
                echo "   #" . $arr_item["id"] . ":hover .icon_fa{ color: ". $arr_item["icon_color_hover"] ."  !important}\r\n";
            }
            if(isset($arr_item["icon_color_disabled"]) && !empty($arr_item["icon_color_disabled"]))
            {
                echo "   #" . $arr_item["id"] . ".scdisabledmain .icon_fa{ color: ". $arr_item["icon_color_disabled"] ."  !important}\r\n";
                echo "   #" . $arr_item["id"] . ".scdisabledsub .icon_fa{ color: ". $arr_item["icon_color_disabled"] ."  !important}\r\n";
            }
        }
    }
    ?>
    </style>
    </head>
    <body>
<head>
    <style>
    .scMenuHHeader *,
    .scMenuHHeader *:before,
    .scMenuHHeader *:after {
      margin: 0;
      padding: 0;
      box-sizing: border-box; 
      }

    .scMenuHHeader {
      height: 45px; 
      box-sizing: border-box;
      padding: 4px 0;
      border-bottom: 3px solid rgba(0, 0, 0, .25); 
      
      background-color: #37476a;
    background-image: none;
    opacity: 1;
    filter: alpha(opacity=100);
    border-color: #37476a;
    border-style: solid;
    border-width: 1px;
      }
      
      .scMenuHHeader .container {
		width: 90%;
        padding: 0 25px;
        margin: 0 auto; }
      .scMenuHHeader .left {
        float: left; }
      .scMenuHHeader .left img {
	    width: 66px; }
      .scMenuHHeader .right {
        float: right; }
        .scMenuHHeader .right:after {
          content: "";
          display: table;
          clear: both;
          width: 100%; }
      .scMenuHHeader .menu {
        margin: 0;
        padding: 0;
        position: relative; }
        .scMenuHHeader .menu li {
          list-style: none; }
        .scMenuHHeader .menu li a {
          font-family: Arial, sans-serif;
          font-size: 13px;
          font-weight: bold;
          text-decoration: none;
          color: #3366CC;
          text-transform: uppercase; }
        .scMenuHHeader .menu .menu-toggler {
          height: 36px;
          border-radius: 2px;
          display: inline-block;
          position: relative;
          z-index: 2; }
        .scMenuHHeader .menu .menu-toggler > img {
          max-width: 24px;
          border-radius: 50%;
          float: left; }
        .scMenuHHeader .menu .menu-toggler > span,
        .scMenuHHeader .menu .menu-toggler > i {
		  color: #fff;
          float: left;
          margin-left: 7px;
          padding: 8px 0;
          transition: all 0.2s;
          -o-transition: all 0.2s;
          -ms-transition: all 0.2s;
          -webkit-transition:all 0.2s;
          -moz-transition:all 0.2s;
          -webkit-backface-visibility: hidden; }
        .scMenuHHeader .menu .menu-toggler > i svg {
          fill: white; }
        .scMenuHHeader .menu .menu-toggler + ul {
          position: absolute;
          min-width: 300px;
          z-index: 9999;
          right: -13px;
          margin-top: -1px;
          border-radius: 2px;
          display: none;
          background: white;
          border: 1px solid rgba(0, 0, 0, 0.085);
          box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.085); }
        .scMenuHHeader .menu .menu-toggler + ul:before,
        .scMenuHHeader .menu .menu-toggler + ul:after {
          bottom: 100%;
          right: 10px;
          border: solid transparent;
          content: " ";
          height: 0;
          width: 0;
          position: absolute;
          pointer-events: none; }
        .scMenuHHeader .menu .menu-toggler + ul:after {
          border-color: rgba(136, 183, 213, 0);
          border-bottom-color: white;
          border-width: 10px;
          margin-left: 0px; }
        .scMenuHHeader .menu .menu-toggler + ul li.menu-item {
          clear: both;
          border-top: 1px solid rgba(0, 0, 0, 0.085); }
        .scMenuHHeader .menu .menu-toggler + ul li.menu-item a {
          display: block;
          padding: 10px 8px;
          color: #333; }
        .scMenuHHeader .menu .menu-toggler + ul li.menu-item a:hover {
          background-color: rgba(0, 0, 0, 0.03); }
        .scMenuHHeader .menu .info {
          padding: 10px 20px; }
        .scMenuHHeader .menu .info .left,
        .scMenuHHeader .menu .info .right {
          float: none;
          vertical-align: top;
          display: table-cell; }
        .scMenuHHeader .menu .info .right {
          padding: 10px; }
		.scMenuHHeader .menu .info .right a {
		  text-transform: none;	}
        .scMenuHHeader .menu .info .left img {
          max-width: 72px;
          border-radius: 100px; }
        .scMenuHHeader .menu .info h4 {
          font-family: Arial, sans-serif;
          font-size: 16px;
          margin-bottom: 15px; }
        .scMenuHHeader .menu .info h4 small {
          font-weight: normal;
          font-size: 13px;
          opacity: .5; }
        .scMenuHHeader .menu .info a {
          font-size: 13px; }
        .scMenuHHeader .menu .info a:hover {
          text-decoration: underline; }
        .scMenuHHeader .menu.open ul {
          display: block; }
        .scMenuHHeader .menu.open .menu-toggler > i {
          transform: rotate(180deg);
          transition: all 0.2s;
          -o-transition: all 0.2s;
          -ms-transition: all 0.2s;
          -webkit-transition:all 0.2s;
          -moz-transition:all 0.2s;
          -webkit-backface-visibility: hidden; }
        .scMenuHHeader .info a {
          text-transform: none;
          font-weight: normal; }
		.scMenuHHeaderFont{
		  font-size: 10px; }
    </style>
    <script type="text/javascript">
    $(function(){
        $('.menu').hover(function(){
            $(this).toggleClass('open');
        });
        /*
        $('.menu').click(function(){
            $(this).toggleClass('open');
        })

        $(document).click(function(e) {
            if(!$(event.target).closest('.menu').length) {
                if($('.menu').hasClass("open")) {
                    $('.menu').removeClass('open');
                }
            }
        });
        */
    })
    </script>
</head>
<div class="scMenuHHeader">
    <div class="container">
        <div class="left">
            <a href="" target="_blank">
                   <IMG SRC="<?php echo $path_imag_cab ?>/usr__NM__bg__NM__Logo2.png" BORDER="0"/>
            </a>
        </div>

        <div class="right">
            <ul class="menu">
                <li>
                    <a class="menu-toggler" href="#">
                           <IMG SRC="<?php echo $path_imag_cab ?>/usr__NM__bg__NM__user.png" BORDER="0"/>
                        <span class="scMenuHHeaderFont"><?php echo "" . $_SESSION['usr_login'] . "" ?></span>
                        <i><img src="../_lib/img/scriptcase__NM__ico__NM__group_expand.png"></i>
                    </a>

                    <ul>
                        <li class="info">
                            <div class="left">
                                   <IMG SRC="<?php echo $path_imag_cab ?>/usr__NM__bg__NM__user.png" BORDER="0"/>
                            </div>
                            
                            <div class="right">
                                <h4>
                                    <?php echo "" . $_SESSION['usr_login'] . "" ?>
                                    <small></small>
                                </h4>
                                
                                <a id="sc_id_lnk_label02" href="" ><?php echo "" ?></a>
                            </div>
                        </li>

                        <li id="sc_id_item_label01" class="menu-item"><a href="<?php echo "../seg_change_pswd" ?>" ><?php echo "Cambiar Password" ?></a></li>
                        <li id="sc_id_item_label02" class="menu-item"><a href="<?php echo "../seg_Login" ?>" target="_parent"><?php echo "Salir" ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
    <?php
        escreveMenuMobile($menu_menuData["data"], $this->path_imag_apl);
    ?>
	<?php
		function escreveMenuMobile($arr_menu, $path_imag_apl)
		{
			$subSize   = 2;
			$subCount  = array();
			$tabSpace  = 1;
			$intMult   = 2;
			$aMenuItemList = array();
			foreach ($arr_menu as $ind => $resto)
			{
				$aMenuItemList[] = $resto;
			}
			?>
			<ul data-role='listview' data-theme='a'>
			<?php
			for ($i = 0; $i < sizeof($aMenuItemList); $i++)
			{
				echo str_repeat(' ', $tabSpace * $intMult); ?><li><?php
				$tabSpace++;
				$sDisabledClass = '';
				if ('Y' == $aMenuItemList[$i]['disabled'])
				{
					$aMenuItemList[$i]['link']   = '#';
					$aMenuItemList[$i]['target'] = '';
				}
				if ('' != $aMenuItemList[$i]['icon'] && file_exists($path_imag_apl . "/" . $aMenuItemList[$i]['icon']))
				{
					$iconHtml = '<img src="../_lib/img/' . $aMenuItemList[$i]['icon'] . '" alt="' . $aMenuItemList[$cont_menu_list_assoc]['hint'] . '" class="ui-li-icon"  />';
				}
				else
				{
					$iconHtml = '';
				}
				if (empty($aMenuItemList[$i]['link']))
				{
					$aMenuItemList[$i]['link']   = '#';
				}

				if($aMenuItemList[$i]['display'] == 'only_img' && $iconHtml != '')
				{
				    $str_item = $iconHtml;
				}
				elseif($aMenuItemList[$i]['display'] == 'text_img' || empty($aMenuItemList[$i]['display']))
				{
				    if($aMenuItemList[$i]['display_position'] != 'img_right')
				    {
				        $str_item = $iconHtml . $aMenuItemList[$i]['label'];    
				    }
				    else
				    {
				        $str_item = $aMenuItemList[$i]['label'] . $iconHtml;
				    }
				}
				elseif($aMenuItemList[$i]['display'] == 'only_fontawesomeicon')
				{
				    $str_item = "<i class='icon_fa menu__icon ". $aMenuItemList[$i]['icon_fa'] ."'></i>";
				}
				elseif($aMenuItemList[$i]['display'] == 'text_fontawesomeicon')
				{
				    if($aMenuItemList[$i]['display_position'] != 'img_right')
				    {
				        $str_item = "<i class='icon_fa ". $aMenuItemList[$i]['icon_fa'] ."'></i> ". $aMenuItemList[$i]['label'] ."";
				    }
				    else
				    {
				        $str_item = $aMenuItemList[$i]['label'] ." <i class='icon_fa ". $aMenuItemList[$i]['icon_fa'] ."'></i>";
				    }
				}
				else
				{
				    $str_item = $aMenuItemList[$i]['label'];
				}

				if (isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] < $aMenuItemList[$i + 1]['level'])
				{
					echo str_repeat(' ', $tabSpace * $intMult); ?><a href="<?php echo $aMenuItemList[$i]['link']; ?>" id="<?php echo $aMenuItemList[$i]['id']; ?>" title="<?php echo $aMenuItemList[$i]['hint']; ?>"><?php echo $str_item; ?></a><?php
					
					if (0 != $subSize && 0 < $aMenuItemList[$i + 1]['level'])
					{
						echo str_repeat(' ', $tabSpace * $intMult);
						$tabSpace++;
						echo str_repeat(' ', $tabSpace * $intMult);
						$tabSpace++;
					}
					echo str_repeat(' ', $tabSpace * $intMult); ?><ul><?php
					$tabSpace++;
				}
				else
				{
					echo str_repeat(' ', $tabSpace * $intMult); ?><a href="<?php echo $aMenuItemList[$i]['link']; ?>" id="<?php echo $aMenuItemList[$i]['id']; ?>" title="<?php echo $aMenuItemList[$i]['hint']; ?>"><?php echo $str_item; ?></a><?php
				}
				
				if ((isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] == $aMenuItemList[$i + 1]['level']) || 
					(isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] > $aMenuItemList[$i + 1]['level']) ||
					(!isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] > 0) ||
					(!isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] == 0))
				{
					$tabSpace--;
					echo str_repeat(' ', $tabSpace * $intMult); ?></li><?php
					
					if (0 != $subSize && 0 < $aMenuItemList[$i]['level'])
					{
						if (!isset($subCount[ $aMenuItemList[$i]['level'] ]))
						{
							$subCount[ $aMenuItemList[$i]['level'] ] = 0;
						}
						$subCount[ $aMenuItemList[$i]['level'] ]++;
					}
					if (isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] > $aMenuItemList[$i + 1]['level'])
					{
						for ($j = 0; $j < $aMenuItemList[$i]['level'] - $aMenuItemList[$i + 1]['level']; $j++)
						{
							unset($subCount[ $aMenuItemList[$i]['level'] - $j]);
							$tabSpace--;
							echo str_repeat(' ', $tabSpace * $intMult); ?></ul><?php
							
							if (0 != $subSize && 0 < $aMenuItemList[$i]['level'])
							{
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
							}
							$tabSpace--;
							
							echo str_repeat(' ', $tabSpace * $intMult); ?></li><?php
							
						}
					}
					elseif (!$aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] > 0)
					{
						for ($j = 0; $j < $aMenuItemList[$i]['level']; $j++)
						{
							unset($subCount[ $aMenuItemList[$i]['level'] - $j]);
							$tabSpace--;
							echo str_repeat(' ', $tabSpace * $intMult); ?></ul><?php
							
							if (0 != $subSize && 0 < $aMenuItemList[$i]['level'])
							{
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
							}
							$tabSpace--;
							echo str_repeat(' ', $tabSpace * $intMult); ?></li><?php
						}
					}
					if ($subSize == $subCount[ $aMenuItemList[$i]['level'] ])
					{
						$subCount[ $aMenuItemList[$i]['level'] ] = 0;
						echo str_repeat(' ', $tabSpace * $intMult);
					}
				}
			}
		?>
		</ul>
		<?php
		}
	?>
    </body>
</html>
