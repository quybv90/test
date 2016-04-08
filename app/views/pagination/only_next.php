<?php if ($paginator->getCurrentPage() < $paginator->getLastPage()): ?>
    <ul class="nav">
        <li><a class="btn btn-primary view-more" href="<?= $paginator->getUrl($paginator->getCurrentPage() + 1) ?>">Còn nhiều lắm, Xem thêm</a></li>
    </ul>
<?php endif; ?>
