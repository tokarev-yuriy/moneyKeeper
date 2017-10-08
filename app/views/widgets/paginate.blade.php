<?php
	$presenter = new \MoneyKeeper\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pagination justify-content-end">
			<?php echo $presenter->render(); ?>
	</ul>
<?php endif; ?>