<?php if ($value) { ?>
<?php $page = \Cms\Classes\PageManager::resolve($value); ?>
<?= e($page->type) ?> / <?= e($page->title) ?>
<?php } ?>