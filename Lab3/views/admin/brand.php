<?php

require_once "../../core/core.php";
require_admin();

require_once "../../controllers/ProductController.php";

$controller = new ProductController();

$brands = $controller->getAllBrands();

// Check if we are editing a brand
$editId = $_GET['edit_id'] ?? '';
$editBrand = null;

if ($editId !== '') {

    // Make sure edit_id is a positive integer
    if (filter_var($editId, FILTER_VALIDATE_INT) !== false && (int) $editId > 0) {

        $editId = (int) $editId;

        // Get the selected brand
        $editBrand = $controller->getBrandById($editId);

        // If the brand does not exist
        if (!$editBrand) {
            $_SESSION['error'] = "Brand not found.";
            header("Location: brand.php");
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
        <?php echo $editBrand ? "Edit Brand" : "Manage Brands"; ?>
    </title>

   <link rel="stylesheet" href="/~fatma.abdourahmane/Ecommerce-class/Lab3/css/style.css">

</head>

<body>

<?php require_once __DIR__ . "/../layout/header.php"; ?>

<main>

    <h1>Manage Brands</h1>

    <?php

    // Display success message
    if (!empty($_SESSION['success'])) {

        echo '<p class="success-message">'
            . htmlspecialchars($_SESSION['success'])
            . '</p>';

        unset($_SESSION['success']);
    }

    // Display error message
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

    <?php if ($editBrand): ?>

        <h2>Edit Brand</h2>

        <form action="../../actions/update_brand_action.php" method="POST">

            <input
                type="hidden"
                name="brand_id"
                value="<?php echo htmlspecialchars($editBrand['brand_id']); ?>"
            >

            <div>

                <label for="brand_name">Brand Name</label>

                <input
                    type="text"
                    name="brand_name"
                    id="brand_name"
                    value="<?php echo htmlspecialchars($editBrand['brand_name']); ?>"
                    required
                >

            </div>

            <div>

                <button type="submit">Update Brand</button>

                <a href="brand.php">Cancel</a>

            </div>

        </form>

    <?php else: ?>

        <h2>Add Brand</h2>

        <form action="../../actions/add_brand_action.php" method="POST">

            <div>

                <label for="brand_name">Brand Name</label>

                <input
                    type="text"
                    name="brand_name"
                    id="brand_name"
                    required
                >

            </div>

            <div>

                <button type="submit">Add Brand</button>

            </div>

        </form>

    <?php endif; ?>

    <h2>Existing Brands</h2>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

        <?php if (!empty($brands)): ?>

            <?php foreach ($brands as $brand): ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($brand['brand_id']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($brand['brand_name']); ?>
                    </td>

                    <td>

                        <a href="brand.php?edit_id=<?php echo htmlspecialchars($brand['brand_id']); ?>">
                            <button type="button">Edit</button>
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td colspan="3">
                    No brands found.
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</main>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>

</body>

</html>