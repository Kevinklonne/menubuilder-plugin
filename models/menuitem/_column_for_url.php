<?php if ($value) { ?>
<?php $page = \Cms\Classes\PageManager::resolve($value); ?>
<?= e($page->title) ?> <small class="fw-lighter text-muted">(<?= e($page->type) ?>)</small>
<?php } ?>
