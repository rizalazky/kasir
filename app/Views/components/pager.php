
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <?php foreach ($pager->links() as $link) { ?>
            <li class="page-item <?= $link['active'] ? 'active"' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php } ?> 
    </ul>
</nav>