<?php 

include('config/db_connect.php');


$title = $email = $ingredients = '';

$errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');

// if(isset($_GET['submit'])){
//     echo $_GET['email'];
//     echo $_GET['title'];
//     echo $_GET['ingredients'];

// }
if(isset($_POST['submit'])){
    // echo htmlspecialchars($_POST['email']);
    // echo htmlspecialchars($_POST['title']);
    // echo htmlspecialchars($_POST['ingredients']);

    // check email
    if(empty($_POST['email'])){
        $errors['email'] = 'An email is required <br/>';
    }else{
         $email = $_POST['email'];
         if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
             $errors['email'] = 'email must be a valid email address';
         }
    }

    // check title
    if(empty($_POST['title'])){
        $errors['title' ] = 'An title is required <br/>';
    }else{
        $title = $_POST['title'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $errors['title'] = 'title must be letter and spaces only';
        }
    }

    // check ingredients
    if(empty($_POST['ingredients'])){
        $errors['ingredients'] = 'Atleast one  ingredients is required <br/>';
    }else{
        $ingredients = $_POST['ingredients'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
            $errors['ingredients'] ='ingredients must be comma seprated list';
        }
    }

    if(array_filter($errors)){
        // echo 'errors in the form';
    } else{
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // create sql
         $sql = "INSERT INTO pizzas(title,email,ingredients)VALUES('$title','$email','$ingredients')";

        //  sdave to db and check
        if(mysqli_query($conn, $sql)){
            // success
            header('Location: index.php');
        } else{
            // error
            echo 'query error:' .mysqli_error($conn);
        }

        // echo 'form is valid';
       
    }

}
// end of post check
?>
<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container grey-text">
<h4 class="center">Add a PIzza</h4>
<form class="white" action="add.php" method="POST">
<label>Your Email:</label>
<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
<div class="red-text">
<?php echo $errors['email']; ?>
</div>
<label>Pizza title:</label>
<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
<div class="red-text">
<?php echo $errors['title']; ?>
</div>
<label>Ingredients (comma seperated):</label>
<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
<div class="red-text">
<?php echo $errors['ingredients']; ?>
</div>
<div class="center">
<input type="submit" name="submit" value="submit" class="btn-brand z-depth-0">
</div>
</form>
</section>

<?php include('templates/footer.php') ?>


</body>
</html>