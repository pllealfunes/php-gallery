<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>


<main>

    <div class="py-6 sm:px-6 lg:px-8">
        <a href="/photo?id=<?= $photo['id'] ?>" class="text-blue-500 underline">go back...</a>
    </div>

    <?php if (isset($successMsg)) : ?>
    <p id="successMsg" class="bg-green-500 text-white mb-2 p-2 font-bold text-center">
        <?= htmlspecialchars($successMsg) ?></p>
    <?php endif; ?>

    <div class="h-1/4 w-1/4 mx-5 px-3">
        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($photo['photo']); ?>"
            alt="<?php echo base64_encode($photo['name']); ?>" class="rounded-lg">
    </div>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <?php if (isset($errors['db'])) : ?>
        <p class="text-red-500"><?= $errors['db'] ?></p>
        <?php endif; ?>

        <div>
            <form method="POST" action="/photo" enctype="multipart/form-data">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="col-span-full">
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="id" value="<?= $photo['id'] ?>">
                                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Photo
                                    Description : </label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="3"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?= $photo['description'] ?></textarea>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Write 255 characters about your photo.
                                </p>
                            </div>
                            <?php if (isset($errors['description'])) : ?>
                            <p class="text-red-500"><?= $errors['description'] ?></p>
                            <?php endif; ?>


                            <div class="col-span-full">
                                <p class="block text-sm font-medium leading-6 text-gray-900">Photo
                                    :</p>
                                <div class="text-black" id="file-name-display">
                                    <?php if (isset($photoName)) : ?>
                                    <p>Selected File: <?= htmlspecialchars($photoName) ?></p>
                                    <?php else : ?>
                                    <p class="font-bold text-orange-400"> If No New File
                                        Selected
                                        Then
                                        Original Image
                                        Remains</p>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="photo"
                                        class="my-2 relative cursor-pointer rounded-md bg-white font-semibold text-white focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-100">
                                        <span class="p-3 rounded-lg bg-indigo-600">Upload a file</span>
                                        <input id="photo" name="photo" type="file" class="sr-only"
                                            onchange="updateFilename()">
                                    </label>
                                </div>
                                <p class="my-2 text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 4GB</p>
                            </div>
                            <?php if (isset($errors['photo'])) : ?>
                            <p class="text-red-500"><?= $errors['photo'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/photos" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
            <button type="submit" name="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
        </div>
        </form>

        <form id="delete-form" class="m-0" action="/photo" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $photo['id'] ?>">
            <button
                class="rounded-md  bg-red-600 px-3 py-2 tfont-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Delete</button>
        </form>

    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>