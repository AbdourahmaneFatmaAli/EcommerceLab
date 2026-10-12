<?php

require_once "../../core/core.php";
require_admin();

require_once "../../controllers/ProductController.php";

$controller = new ProductController();

$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();

$editId = $_GET['edit_id'] ?? '';
$editCategory = null;

if ($editId !== '') {

    if (filter_var($editId, FILTER_VALIDATE_INT) !== false && (int) $editId > 0) {

        $editId = (int) $editId;

        $editCategory = $controller->getCategoryById($editId);

        if (!$editCategory) {
            $_SESSION['error'] = "Category not found.";
            header("Location: category.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $editCategory ? "Edit Category" : "Manage Categories"; ?>
    </title>
<link rel="stylesheet" href="/~fatma.abdourahmane/Ecommerce-class/Lab3/css/style.css">

</head>

<body>

<?php require_once __DIR__ . "/../layout/header.php"; ?>

<main>

    <h1>Manage Categories</h1>

    <?php

    if (!empty($_SESSION['success'])) {

        echo '<p class="success-message">'
            . htmlspecialchars($_SESSION['success'])
            . '</p>';

        unset($_SESSION['success']);
    }

    if (!empty($_SESSION['error'])) {

        echo '<p class="error-message" style="
            border: none !important;
            border-left: none !important;
            box-shadow: none !important;
        ">'
            . htmlspecialchars($_SESSION['error'])
            . '</p>';

        unset($_SESSION['error']);
    }

    ?>


    <?php if ($editCategory): ?>

        <h2>Edit Category</h2>

        <form action="../../actions/update_category_action.php" method="POST">

            <input
                type="hidden"
                name="cat_id"
                value="<?php echo htmlspecialchars($editCategory['cat_id']); ?>"
            >

            <div>

                <label for="brand_id">Brand</label>

                <select name="brand_id" id="brand_id" required>

                    <option value="">Select Brand</option>

                    <?php foreach ($brands as $brand): ?>

                        <option
                            value="<?php echo htmlspecialchars($brand['brand_id']); ?>"
                            <?php
                            echo ((int) $brand['brand_id'] === (int) $editCategory['brand_id'])
                                ? 'selected'
                                : '';
                            ?>
                        >
                            <?php echo htmlspecialchars($brand['brand_name']); ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div>

                <label for="cat_name">Category Name</label>

                <input
                    type="text"
                    name="cat_name"
                    id="cat_name"
                    value="<?php echo htmlspecialchars($editCategory['cat_name']); ?>"
                    required
                >

            </div>


            <div>

                <button type="submit">Update Category</button>

                <a href="category.php">Cancel</a>

            </div>

        </form>

    <?php else: ?>

        <h2>Add Category</h2>

        <form action="../../actions/add_category_action.php" method="POST">

            <div>

                <label for="brand_id">Brand</label>

                <select name="brand_id" id="brand_id" required>

                    <option value="">Select Brand</option>

                    <?php foreach ($brands as $brand): ?>

                        <option value="<?php echo htmlspecialchars($brand['brand_id']); ?>">
                            <?php echo htmlspecialchars($brand['brand_name']); ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div>

                <label for="cat_name">Category Name</label>

                <input
                    type="text"
                    name="cat_name"
                    id="cat_name"
                    required
                >

            </div>


            <div>

                <button type="submit">Add Category</button>

            </div>

        </form>

    <?php endif; ?>


    <h2>Existing Categories</h2>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

        <?php if (!empty($categories)): ?>

            <?php foreach ($categories as $category): ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($category['cat_id']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($category['brand_name'] ?? 'No Brand'); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($category['cat_name']); ?>
                    </td>

                    <td>

                        <a href="category.php?edit_id=<?php echo htmlspecialchars($category['cat_id']); ?>">
                            <button type="button">Edit</button>
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td colspan="4">
                    No categories found.
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</main>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>

</body>

</html>