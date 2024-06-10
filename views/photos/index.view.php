<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <?php if (isset($successMsg)) : ?>
    <p id="successMsg" class="bg-green-500 text-white mb-2 p-2 font-bold text-center">
        <?= htmlspecialchars($successMsg) ?></p>
    <?php endif; ?>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div>
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <?php foreach ($photos as $photo) : ?>
                    <li class="list-none">
                        <a href="/photo?id=<?= $photo['id'] ?>" class="group">
                            <div
                                class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($photo['photo']); ?>"
                                    alt="" class="h-full w-full object-cover object-center group-hover:opacity-75">
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>