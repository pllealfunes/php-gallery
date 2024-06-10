<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p class="mb-6">
            <a href="/photos" class="text-blue-500 underline">go back...</a>
        </p>
        <div class="h-1/4 w-1/4">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($photo['photo']); ?>"
                alt="<?php echo base64_encode($photo['name']); ?>" class="rounded-lg">
        </div>
        <div class="mt-3">
            <p>Photo Uploaded: <?= htmlspecialchars($photo['created_at']) ?></p>
            <p>Last Updated: <?= htmlspecialchars($photo['updated_at']) ?></p>
        </div>
        <h3 class="mt-10">Description :</h3>
        <p class="mt-7"><?= htmlspecialchars($photo['description']) ?></p>
    </div>

    <footer class="m-6">
        <a href="/photo/edit?id=<?= $photo['id'] ?>"
            class="inline-flex justify-center rounded-md border border-transparent bg-gray-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Edit</a>
    </footer>

</main>

<?php require base_path('views/partials/footer.php') ?>