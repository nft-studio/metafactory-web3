<div class="bmt-menu-toggle"><i class="fa fa-bars"></i></div>
<div class="bmt-sidebar main-menu">
	<div class="bmt-sidebar-header">
		<div class="bmt-side-logo">
			<img src="/bmt/layout/images/logo_w.png" style="width:100%" width="100%">
		</div>
	</div>
	<div class="bmt-wrap-menu nano">
		<div class="nano-content">
			<a href="<?php echo $subdomain; ?>/bmt/" class="bmt-menu-button <?php if ($route == 'index') {
																				echo 'bmt-menu-button-active';
																			} ?>">
				<?php echo $bmt_locales['dashboard']['menu']; ?></a>
			<a href="<?php echo $subdomain; ?>/bmt/pages" class="bmt-menu-button <?php if ($route == 'pages') {
																						echo 'bmt-menu-button-active';
																					}
																					?>">
				<?php echo $bmt_locales['pages']['menu']; ?></a>
			<?php if (mainnet_contract_address != "" || testnet_contract_address != "") { ?>
				<a href="<?php echo $subdomain; ?>/bmt/nfts" class="bmt-menu-button <?php if ($route == 'nfts') {
																						echo 'bmt-menu-button-active';
																					} ?>">
					NFTs</a>
			<?php } ?>
			<a href="<?php echo $subdomain; ?>/bmt/menu" class="bmt-menu-button <?php if ($route == 'menu') {
																					echo 'bmt-menu-button-active';
																				} ?>">
				<?php echo $bmt_locales['menu']['menu']; ?></a></a>
			<?php if (count($dataTypes) > 0) { ?>
				<a href="javascript:openSubmenu('datatypes')" class="bmt-menu-button <?php if ($route == 'customdata') {
																							echo 'bmt-menu-button-active';
																						} ?>">
					Off-chain data</a></a>
				<div class="bmt-wrap-submenu" id="datatypes">
					<?php
					foreach ($dataTypes as $datatypeName) { ?>
						<?php if ($datatypeName != 'traits') { ?>
							<a href="<?php echo $subdomain; ?>/bmt/datatype-<?php echo $datatypeName; ?>" class="bmt-menu-button">
								<?php echo ucfirst($datatypeName); ?></a>
						<?php } else { ?>
							<?php if (mainnet_contract_address != "" || testnet_contract_address != "") { ?>
								<a href="<?php echo $subdomain; ?>/bmt/datatype-<?php echo $datatypeName; ?>" class="bmt-menu-button">
									<?php echo ucfirst($datatypeName); ?></a>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<a href="<?php echo $subdomain; ?>/bmt/translations" class="bmt-menu-button <?php if ($route == 'translations') {
																							echo 'bmt-menu-button-active';
																						} ?>">
				<?php echo $bmt_locales['translations']['menu']; ?></a></a>
			<a href="javascript:openSubmenu('utility')" class="bmt-menu-button 
				<?php if ($route == 'filemanager' || $route == 'database') {
					echo 'bmt-menu-button-active';
				} ?>">
				<?php echo $bmt_locales['utility']['menu']; ?></a></a>
			<div class="bmt-wrap-submenu" id="utility">
				<a href="<?php echo $subdomain; ?>/bmt/file-manager" class="bmt-menu-button">
					<?php echo $bmt_locales['file_manager']['menu']; ?></a></a>
				<?php if (getUserLevel($user['level']) == 5) { ?>
					<a href="<?php echo $subdomain; ?>/bmt/manage-htaccess" class="bmt-menu-button ">
						<?php echo $bmt_locales['manage-htaccess']['menu']; ?></a>
					</a>
				<?php } ?>
			</div>
			<a href="javascript:openSubmenu('settings')" class="bmt-menu-button 
				<?php if ($route == 'admins' || $route == 'datatypes' || $route == 'configs') {
					echo 'bmt-menu-button-active';
				} ?>">
				<?php echo $bmt_locales['settings']['menu']; ?></a></a>
			<div class="bmt-wrap-submenu" id="settings">
				<a href="<?php echo $subdomain; ?>/bmt/admins" class="bmt-menu-button">
					<?php echo $bmt_locales['manage_admins']['menu']; ?></a>
				</a>
				<?php if (getUserLevel($user['level']) == 5) { ?>
					<a href="<?php echo $subdomain; ?>/bmt/configs" class="bmt-menu-button">
						Manage <?php echo $bmt_locales['configs']['menu']; ?>
					</a>
					<a href="<?php echo $subdomain; ?>/bmt/manage-datatypes" class="bmt-menu-button">
						Manage off-chain data
					</a>
				<?php } ?>
			</div>
			<a href="<?php echo $subdomain; ?>/bmt/info" class="bmt-menu-button <?php if ($route == 'info') {
																					echo 'bmt-menu-button-active';
																				} ?>">
				<?php echo $bmt_locales['info']['menu']; ?>
			</a>
			<a href="<?php echo $subdomain; ?>/bmt/logout" class="bmt-menu-button">
				<?php echo $bmt_locales['logout']['menu']; ?>
			</a>
		</div>
		<!--nano-content-->
	</div>
	<!--bmt-wrap-menu-->
</div>
<!--bmt-sidebar-->