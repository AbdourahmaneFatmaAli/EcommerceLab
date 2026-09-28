<?php
// views/layout/header.php
// ------------------------------------------------------------
// Shared navigation for the website.
//
// This file only reads session information using the shared
// functions from core.php. It does not run SQL or contain
// business logic.
//
// The page including this file must load core.php first so that
// the session and functions such as is_logged_in() are available.
?>

<nav>

    <a href="../index.php">Home</a>

    |

    <?php if (is_logged_in()) { ?>

        Welcome,
        <?php echo htmlspecialchars($_SESSION['customer_name']); ?>

        |

        <a href="my_account.php">My Account</a>

        |

        <a href="../logout.php">Logout</a>

    <?php } else { ?>

        <a href="register.php">Register</a>

        |

        <a href="login.php">Login</a>

    <?php } ?>

</nav>