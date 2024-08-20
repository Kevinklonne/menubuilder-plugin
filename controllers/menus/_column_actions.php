<button data-request="onDuplicate"
        data-request-data="id: '<?= $record->id ?>'"
        data-request-confirm="<?= e(trans('kevinklonne.menubuilder::lang.menu.duplicate_confirm')) ?>"
        data-stripe-load-indicator
        title="<?= e(trans('kevinklonne.menubuilder::lang.menu.duplicate_tooltip')) ?>"
        class="btn btn-primary btn-sm"><i class="octo-icon-copy"></i></button>
