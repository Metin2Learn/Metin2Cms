<?php
	@ob_start();
	include 'include/functions/header.php';
?>
<!DOCTYPE html>
<html lang="<?php print $language_code; ?>"<?php if(in_array($language_code, $rtl)) print ' dir="rtl"'; ?>>
  <head>
    <meta charset="utf-8" />
    <title><?php print $site_title.' - '.$title; if($offline) print ' - '.$lang['server-offline']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <link rel="stylesheet" type="text/css" href="<?php print $site_url; ?>css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $site_url; ?>css/owl.carousel.min.css" />
	<link href="<?php print $site_url; ?>css/font-awesome.css?v=2.12" rel="stylesheet">
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.2/css/pro.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php print $site_url; ?>css/nice-select.css" />
    <link rel="stylesheet" href="<?php print $site_url; ?>css/default-edit.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $site_url; ?>css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $site_url; ?>css/responsive.css" />
	<link rel="shortcut icon" href="<?php print $site_url; ?>images/favicon.ico">
    <!--End ALL STYLESHEET -->
	<?php
		if($page=="admin" && $a_page=="player_edit") 
			print '<link rel="stylesheet" href="'.$site_url.'css/bootstrap-select.css?v=2.12">';
	?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body>
    <!-- preloader -->
    <div id="preloader"></div>
    <!-- preloader-end -->
    <!-- main-wrap -->
    <div class="main-wrap">
      <!-- offcanvas-start -->
      <div class="offcanvas-menu">
        <ul class="offmenu" id="menuParent">
          <a href="#" class="offcanvas-close"><i class="fal fa-times"></i></a>
            <li><a href="<?php echo $site_url; ?>news/"><?php echo $lang['news']; ?></a></li>
            <li><a href="<?php echo $site_url; ?>download"><?php echo $lang['download']; ?></a></li>
			<?php if(!$database->is_loggedin()) { ?>
            <li><a href="<?php echo $site_url; ?>users/register"><?php echo $lang['register']; ?></a></li>
			<?php } else { ?>
            <li><a href="<?php echo $site_url; ?>user/administration"><?php echo $lang['account-data']; ?></a></li>
			<?php } ?>
            <li><a href="<?php echo $site_url; ?>ranking/players"><?php echo $lang['ranking']; ?></a></li>
            <li><a href="<?php print $shop_url; ?>" target="_blank">Item Shop</a></li>
            <li><a href="<?php print $social_links['discord']; ?>" target="_blank">Discord</a></li>
        </ul>
      </div>
      <div class="offcanvas-overlay"></div>
      <!-- offcanvas-start-end -->

      <!-- header-section -->
      <header class="header-section">
        <div class="container">
          <div class="header-section-inner">
            <div class="main-menu d-xl-block d-none">
              <ul>
                <li><a href="<?php echo $site_url; ?>news/"><?php echo $lang['news']; ?></a></li>
                <li><a href="<?php echo $site_url; ?>download"><?php echo $lang['download']; ?></a></li>
				<?php if(!$database->is_loggedin()) { ?>
                <li><a href="<?php echo $site_url; ?>users/register"><?php echo $lang['register']; ?></a></li>
				<?php } else { ?>
                <li><a href="<?php echo $site_url; ?>user/administration"><?php echo $lang['account-data']; ?></a></li>
				<?php } ?>
                <li>
                  <a class="header-logo" href="<?php echo $site_url; ?>"><img src="<?php print $site_url; ?>images/logo.png" alt=""/></a>
                </li>
                <li><a href="<?php echo $site_url; ?>ranking/players"><?php echo $lang['ranking']; ?></a></li>
                <li><a href="<?php print $social_links['discord']; ?>" target="_blank">Discord</a></li>
              </ul>
            </div>
			<div class="lan-select">
				<img src="<?php echo $site_url.'images/flags/'.$language_code; ?>.png" alt="">
				<select class="nice-select right">
					<option value="<?php echo $language_code; ?>"><?php print $json_languages['languages'][$language_code]; ?></option>
					<?php
						foreach($json_languages['languages'] as $key => $value)
							if($language_code!=$key)
								print '<option value="'.$key.'">'.$value.'</option>';
					?>
				</select>
			</div>
            <a href="<?php echo $site_url; ?>" class="header-logo ms-auto d-xl-none d-block"><img src="<?php print $site_url; ?>images/logo.png" alt=""/></a>
            <a class="offcanvas-open ms-auto d-xl-none d-block">
              <i class="far fa-bars"></i>
            </a>
          </div>
        </div>
      </header>
      <!--End header-section -->

      <!-- main -->
      <main>
        <!-- hero-section -->
        <section class="hero-section">
          <div class="container">
            <div class="hero-section-inner">
              <div class="hero-cont1">
				<?php if($jsondataFunctions['players-online']) { ?>
                <div class="single-cont">
                  <div class="image">
                    <img src="<?php print $site_url; ?>images/player-online.png" alt="" />
                  </div>
                  <div class="txt-c">
                    <h4><?php print number_format($loaded_stats['players-online'], 0, '', ','); ?></h4>
                    <h3><?php print $lang['players-online']; ?></h3>
                  </div>
                </div>
				<?php } if($jsondataFunctions['players-online-last-24h']) { ?>
                <div class="single-cont">
                  <div class="image">
                    <img src="<?php print $site_url; ?>images/player-online.png" alt="" />
                  </div>
                  <div class="txt-c">
                    <h4><?php print number_format($loaded_stats['players-online-last-24h'], 0, '', '.'); ?></h4>
                    <h3><?php print $lang['players-online']; ?> <span class="dc">(24h)</span></h3>
                  </div>
                </div>
				<?php } ?>
              </div>
            </div>
          </div>
        </section>
        <!-- hero-section end -->

        <!-- section-wrapper1 -->
        <div class="section-wrapper1">
          <div class="container">
            <div class="section-wrapper1-inner">
              <!-- main-section -->
              <section class="main-section">
                <div class="h-0">&nbsp;</div>
                <div class="main-section-inner">
                  <aside class="m-sidebar m-sidebar-left">
                    <div class="s-box">
                      <img
                        src="<?php print $site_url; ?>images/s-box-border-img.png"
                        alt=""
                        class="border-img"
                      />
                      <div class="s-box-header">
                        <img
                          class="bg-img"
                          src="<?php print $site_url; ?>images/s-box-title.png"
                          alt=""
                        />
                        <div class="header-cont">
                          <h3>LOGIN</h3>
                        </div>
                      </div>
					  <?php if($offline || !$database->is_loggedin()) { ?>
                      <form method="post" action="<?php print $site_url; ?>users/login">
                      <div class="s-box-form">
                        <div class="single-input-x">
                          <div class="single-input-x-input-outer">
                            <div class="icon">
                              <img src="<?php print $site_url; ?>images/user-icon.png" alt="" />
                            </div>
							<input name="username" type="text" class="single-input-x-input" placeholder="<?php print $lang['user-name-or-email']; ?>" required="" min="5" pattern=".{5,64}" maxlength="64" <?php if($offline) print 'disabled'; else print 'required'; ?>>
                          </div>
                        </div>
                        <div class="single-input-x mb-0">
                          <div class="single-input-x-input-outer">
                            <div class="icon">
                              <img src="<?php print $site_url; ?>images/lock-icon.png" alt="" />
                            </div>
                            <input name="password" type="password" class="single-input-x-input" placeholder="<?php print $lang['password']; ?>" required="" min="5" pattern=".{5,16}" maxlength="16" <?php if($offline) print 'disabled'; else print 'required'; ?>>
                          </div>
                        </div>
                        <div class="bt-row">
                          <?php if(!$offline) { ?>
                          <label class="captcha">
                            <div class="g-recaptcha login-captcha" data-theme="dark" data-sitekey="<?php print $site_key; ?>"></div>
                          </label>
                          <?php } ?>
                          <div class="form-fgt">
							<a href="<?php print $site_url; ?>users/lost">
								<?php print $lang['forget-password']; ?>
							</a>
						  </div>
                        </div>
                        <div class="d-flex justify-content-center pt-3">
                          <button type="submit" class="submit-button default-button mt-1">
                            LOG IN
                          </button>
                        </div>
                      </div>
                      </form>
					  <?php } else { ?>
					<div class="server-statistics-table">
                        <div class="table-sm-st table-sm-st-str1">
                          <div class="table-st1 table-str2 table-user">
							<?php if($web_admin) { ?>
							<a href="<?php print $site_url; ?>admin">
								<div class="single-row"><div class="column">
									<i class="fas fa-cogs"></i> <?php print $lang['administration']; ?>
								</div></div>
							</a>
							<?php
									$count_donations = count(get_donations());
									if($count_donations)
									{
							?>	
							<a href="<?php print $site_url; ?>admin/donatelist">
								<div class="single-row"><div class="column">
									<i class="fas fa-euro-sign"></i> <?php print $count_donations.' '.$lang['new-donations']; ?>
								</div></div>
							</a>
							<?php
									}
								} 
							?>
							<a href="<?php print $site_url; ?>user/administration">
								<div class="single-row"><div class="column">
									<i class="fa fa-user"></i> <?php print $lang['account-data']; ?>
								</div></div>
							</a>
							<a href="<?php print $site_url; ?>user/characters">
								<div class="single-row"><div class="column">
									<i class="fa fa-users"></i> <?php print $lang['chars-list']; ?>
								</div></div>
							</a>
							<a href="<?php print $site_url; ?>user/redeem">
								<div class="single-row"><div class="column">
									<i class="fa fa-barcode"></i> <?php print $lang['redeem-codes']; ?>
								</div></div>
							</a>
							<?php if($jsondataFunctions['active-referrals']) { ?>
							<a href="<?php print $site_url; ?>user/referrals">
								<div class="single-row"><div class="column">
									<i class="fa fa-users"></i> <?php print $lang['referrals']; ?>
								</div></div>
							</a>
							<?php } if($shop_url) { ?>
							<a href="<?php print $shop_url; ?>" target="_blank">
								<div class="single-row"><div class="column">
									<i class="fa fa-shopping-cart"></i> <?php print $lang['item-shop']; ?>
								</div></div>
							</a>
							<?php }
								$vote4coins = file_get_contents('include/db/vote4coins.json');
								$vote4coins = json_decode($vote4coins, true);
								
								if(count($vote4coins))
								{
							?>
							<a href="<?php print $site_url; ?>user/vote4coins">
								<div class="single-row"><div class="column">
									<i class="fas fa-coins"></i> Vote4Coins
								</div></div>
							</a>
							<?php 
								}
								$donate = file_get_contents('include/db/donate.json');
								$donate = json_decode($donate, true);
								if(count($donate))
								{
							?>
							<a href="<?php print $site_url; ?>user/donate">
								<div class="single-row"><div class="column">
									<i class="fas fa-money-bill-wave"></i> <?php print $lang['donate']; ?>
								</div></div>
							</a>
							<?php
								}
							?>
							<a class="logout" href="<?php print $site_url; ?>users/logout">
								<div class="single-row"><div class="column">
									<i class="fas fa-sign-out-alt"></i> <?php print $lang['logout']; ?>
								</div></div>
							</a>
						</div>
					</div>
				</div>
					  <?php } ?>
                    </div>

                    <!-- s-box-2 -->
					<?php if(!$offline) { ?>
                    <div class="s-box s-box-s2">
                      <img
                        src="<?php print $site_url; ?>images/s-box-s2-border.png"
                        alt=""
                        class="border-img"
                      />
                      <div class="s-box-header">
                        <img
                          class="bg-img"
                          src="<?php print $site_url; ?>images/s-box-title.png"
                          alt=""
                        />
                        <div class="header-cont">
                          <h3><?php print $lang['players']; ?></h3>
                        </div>
                      </div>
					  <?php
						$top = $jsondataRanking['top10backup']['players'];
						if(count($top)) {
					  ?>
                      <div class="gold-player">
                        <div class="gold-player__image">
                          <img src="<?php print $site_url.'images/job/'.$top[0]['job']; ?>.png" alt="" class="img"/>
                          <div class="gold-player__bdg">
                            <img src="<?php print $site_url; ?>images/gold.png" alt="" />
                          </div>
                        </div>
                        <div class="gold-player__content">
                          <h4>
                            <?php print $top[0]['name']; ?>
                            <span class="yll emp-<?php print $top[0]['empire']; ?>"> &nbsp;&nbsp; [<?php print empire_name($top[0]['empire']); ?>]</span>
                          </h4>
                          <h5>
                            <?php print $top[0]['guild_name']; ?> <span class="line"></span> Lvl. &nbsp;
                            <span class="wht"> <?php print $top[0]['level']; ?></span>
                          </h5>
                        </div>
                      </div>
                      <div class="table-st1 table-st1-str1">
                        <table>
                          <tbody>
							<?php 
								$i=0; foreach($top as $player) { $i++; if($i==1) continue;
							?>
                            <tr>
                              <td>
							  <?php	if($i==2)
								  print '<img src="'.$site_url.'images/silver.png" alt="" />';
								  else if($i==3) print '<img src="'.$site_url.'images/bronze.png" alt="" />';
								  else print '<span class="no">'.$i.'</span>';
							  ?>
							  </td>
                              <td><?php print $player['name']; ?></td>
                              <td>
                                <span class="emp-<?php print $player['empire']; ?>"><?php print empire_name($player['empire']); ?></span>
                              </td>
                              <td>
                                <span class="color-lt">Lvl.</span>
                                <?php print $player['level']; ?>
                              </td>
                            </tr>
							<?php } ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="ac-bottom-button">
                        <a href="<?php print $site_url; ?>ranking/players" class="default-button">Top 100 &raquo;</a>
                      </div>
                      <?php } ?>
                    </div>
                    <?php } ?>
                  </aside>
                  <div class="m-main-part">
                    <div class="m-slider m-slider-active owl-carousel slider-arrow-1 slider-dots-1">
                      <div class="m-slide">
                        <div class="m-box m-box-design1 mb-0">
                          <div class="content-ud h-100" style="background: url('<?php print $site_url; ?>images/update-bg.png') no-repeat center center/cover;"></div>
                          <div class="m-slide-caption">
                            <h3><?php print $site_title; ?></h3>
                            <h4 class="mb-0">Register now and start play !</h4>
                          </div>
                        </div>
                      </div>
                      <div class="m-slide">
                        <div class="m-box m-box-design1 mb-0">
                          <div class="content-ud h-100" style="background: url('<?php print $site_url; ?>images/update-bg.png') no-repeat center center/cover;"></div>
                          <div class="m-slide-caption">
                            <h3><?php print $site_title; ?></h3>
                            <h4 class="mb-0">Register now and start play !</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="m-box xy-news-part">
						<?php include 'pages/'.$page.'.php'; ?>
                    </div>
                  </div>
                  <aside class="m-sidebar m-sidebar-right">
					<?php if(!$offline && $statistics) { ?>
                    <div class="s-box">
                      <img
                        src="<?php print $site_url; ?>images/s-box-border-img.png"
                        alt=""
                        class="border-img"
                      />
                      <div class="s-box-header">
                        <img
                          class="bg-img"
                          src="<?php print $site_url; ?>images/s-box-title.png"
                          alt=""
                        />
                        <div class="header-cont">
                          <h3><?php print $lang['statistics']; ?></h3>
                        </div>
                      </div>
                      <div class="server-statistics-table">
                        <div class="table-sm-st table-sm-st-str1">
                          <div class="table-st1 table-str2">
                            <table>
                              <tbody>
								<?php
								foreach($jsondataFunctions as $key => $status)
									if(!in_array($key, ['active-registrations', 'players-debug', 'active-referrals', 'full-news-text', 'fb-comments-news']) && $status)
									{
								?>
                                <tr>
                                  <td>&bull;&nbsp; <?php if($key!='players-online-last-24h') print $lang[$key]; else print str_replace("(24h)", '<span class="color-theme2">(24h)</span>', $lang[$key]); ?></td>
                                  <td><?php print number_format($loaded_stats[$key], 0, '', ' '); ?></td>
                                </tr>
								<?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="table-update-time__outer">
                          <div class="table-update-time">
                            <img
                              src="<?php print $site_url; ?>images/arrow-round.png"
                              alt=""
                              class="arrow-r"
                            />
                            <span>
								<a href="" class="reload-s-button">
									Last update: <span class="bright"><?php print time_elapsed_string($last_modified_time_stats, true); ?></span>
								</a>
							</span>
                          </div>
                        </div>
                      </div>
                    </div>
					<?php } ?>
                    <!-- s-box-2 -->
					<?php if(!$offline) { ?>
                    <div class="s-box s-box-s2">
                      <img
                        src="<?php print $site_url; ?>images/s-box-s2-border.png"
                        alt=""
                        class="border-img"
                      />
                      <div class="s-box-header">
                        <img
                          class="bg-img"
                          src="<?php print $site_url; ?>images/s-box-title.png"
                          alt=""
                        />
                        <div class="header-cont">
                          <h3><?php print $lang['guilds']; ?></h3>
                        </div>
                      </div>
					  <?php
						$top = $jsondataRanking['top10backup']['guilds'];
						if(count($top)) {
					  ?>
                      <div class="gold-player">
                        <div class="gold-player__image">
                          <img src="<?php print $site_url.'images/job/'.$top[0]['master_job']; ?>.png" alt="" class="img"/>
                          <div class="gold-player__bdg">
                            <img src="<?php print $site_url; ?>images/gold.png" alt="" />
                          </div>
                        </div>
                        <div class="gold-player__content">
                          <h4>
                            <?php print $top[0]['name']; ?>
                            <span class="yll emp-<?php print $top[0]['empire']; ?>"> &nbsp;&nbsp; [<?php print empire_name($top[0]['empire']); ?>]</span>
                          </h4>
                          <h5>
                            <?php print $top[0]['master_name']; ?> <span class="line"></span> Lvl. &nbsp;
                            <span class="wht"> <?php print $top[0]['ladder_point']; ?></span>
                          </h5>
                        </div>
                      </div>
                      <div class="table-st1 table-st1-str1">
                        <table>
                          <tbody>
							<?php $i=0; foreach($top as $guilds) { $i++; if($i==1) continue; ?>
                            <tr>
                              <td>
							  <?php	if($i==2)
								  print '<img src="'.$site_url.'images/silver.png" alt="" />';
								  else if($i==3) print '<img src="'.$site_url.'images/bronze.png" alt="" />';
								  else print '<span class="no">'.$i.'</span>';
							  ?>
							  </td>
                              <td><?php print $guilds['name']; ?></td>
                              <td>
                                <span class="emp-<?php print $guilds['empire']; ?>"><?php print empire_name($guilds['empire']); ?></span>
                              </td>
                              <td>
                                <?php print number_format($guilds['ladder_point'], 0, '', '.'); ?>
                              </td>
                            </tr>
							<?php } ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="ac-bottom-button">
                        <a href="<?php print $site_url; ?>ranking/guilds" class="default-button">Top 100 &raquo;</a>
                      </div>
                      <?php } ?>
                    </div>
					<?php } ?>
                  </aside>
                </div>
              </section>
              <!-- main-section-end -->
            </div>
          </div>
        </div>
        <!-- section-wrapper1-end -->
      </main>
      <!-- main end -->

      <!-- footer-section -->
      <footer class="footer-section">
        <div class="footer-bottom">
          <div class="container">
            <div class="footer-b-left">
              <p class="footer-p">
                &copy; 2023
                <a href="#" class="blue-c"><?php print $site_title; ?></a>
                All rights reserved.
              </p>
            </div>
          </div>
        </div>
      </footer>
      <!--End footer-section -->
    </div>
    <!-- main-wrap -->

    <!-- js -->
    <script src="<?php print $site_url; ?>js/jquery-3.6.0.min.js"></script>
    <script src="<?php print $site_url; ?>js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo $site_url; ?>js/jquery.nice-select.min.js"></script>
    <script src="<?php print $site_url; ?>js/jquery.scrollUp.min.js"></script>
    <script src="<?php print $site_url; ?>js/owl.carousel.min.js"></script>
	<script>
		var site_url = "<?php print $site_url; ?>";
	</script>
    <script src="<?php print $site_url; ?>js/main.js"></script>
	<?php include 'include/functions/footer.php'; ?>
    <!-- End All Js -->
  </body>
</html>