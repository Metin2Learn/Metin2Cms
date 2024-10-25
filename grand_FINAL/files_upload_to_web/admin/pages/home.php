<?php

?>
			<!-- BEGIN CONTENT HEADER -->
			<section class="content-header">
				<i class="fa fa-home"></i>
				<span>Dashboard</span>
				<ol class="breadcrumb">
					<li><a href="index.php"><?= Language::getTranslation("home") ?></a></li>
					<li class="active"><?= Language::getTranslation("dashBoard") ?></li>
				</ol>
			</section>
			<!-- END CONTENT HEADER -->

			<!-- BEGIN MAIN CONTENT -->
			<section class="content">
				<div class="row">
                <div class="row">
                    <!-- BEGIN CALENDAR -->
                    <div class="col-md-12">
                        <div class="grid box-calendar">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="grid-body bg-olive">
										<span class="date">
											<?= Core::makeShortDate(date('Y-m-d H:i:s')) ?>
										</span>
                                        <hr>
										<span class="notification">
											<i class="fa fa-bell-o"></i> <?= Language::getTranslation("onlinePlayers").Player::playersOnline() ?>
										</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- BEGIN WIDGET -->
					<div class="col-sm-12">
						<div class="row">
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-light-blue">
									<div class="grid-body">
										<span class="title"><?= Language::getTranslation("regUsers") ?></span>
										<span class="value"><?= Core::numberOfAccounts() ?></span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-green">
									<div class="grid-body">
                                        <span class="title"><?= Language::getTranslation("players") ?></span>
                                        <span class="value"><?= Core::numberOfPlayers() ?></span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-purple">
									<div class="grid-body">
                                        <span class="title"><?= Language::getTranslation("guilds") ?></span>
                                        <span class="value"><?= Core::numberOfGuilds() ?></span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-red">
									<div class="grid-body">
                                        <span class="title"><?= Language::getTranslation("news") ?></span>
                                        <span class="value"><?= News::NumberOfNews() ?></span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-orange">
									<div class="grid-body">
                                        <span class="title"><?= Language::getTranslation("tickets") ?></span>
                                        <span class="value"><?= TicketSystem::count() ?></span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-teal">
									<div class="grid-body">
                                        <span class="title"><?= Language::getTranslation("downloads") ?></span>
                                        <span class="value"><?= Download::count() ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                    <?php
                    if(Tasks::count(false) > 0)
                    {
                        ?>

				<div class="row">

					<!-- BEGIN WORK PROGRESS -->
					<div class="col-md-12">
						<div class="grid work-progress no-border">
							<div class="grid-header">
								<span class="title"><?= Language::getTranslation("workProgress") ?></span>
							</div>
							<div class="grid-body">
                                <?php
                                Tasks::printDashboard();
                                ?>
							</div>
						</div>
					</div>
					<!-- END WORK PROGRESS -->
				</div>
                    <?php
                    }
                    ?>

			</section>
			<!-- END MAIN CONTENT -->