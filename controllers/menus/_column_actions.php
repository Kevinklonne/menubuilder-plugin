<button data-request="onDuplicate"
        data-request-data="id: '<?= $record->id ?>'"
        data-request-confirm="<?= e(trans('kevinklonne.menubuilder::lang.menu.duplicate_confirm')) ?>"
        data-stripe-load-indicator
        class="btn btn-primary btn-sm"><i class="octo-icon-copy"></i></button>
