<?php
require_once "vendor/autoload.php";

function data($x)
{
    if (isset($_POST[$x])) {
        echo $_POST[$x];
    }
}

//if (isset($_POST['insert'])) {
//    $newEmployee = new Employee();
//    $file = new XmlHandler("./Model/EmployeeData.xml");
//    $xmlRootElement = $file->readXmlFile();
//    $data = [
//        "name" => $_POST["name"],
//        "phone" => $_POST["phone"],
//        "address" => $_POST["address"],
//        "Email" => $_POST["email"],
//    ];
//    $newEmployee->createEmployeeElement($xmlRootElement, $data, "employee");
//    $file->saveData($xmlRootElement);
//}


//Routes::router();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <table>
        <tr>
            <th><label>Name</label></th>
            <td><input type="text" name="name" value="<?php data("name"); ?>"></td>
        </tr>
        <tr>
            <th><label>Phone</label></th>
            <td><input type="text" name="phone" value="<?php data("phone"); ?>"></td>

        </tr>
        <tr>
            <th><label>Address</label></th>
            <td><input type="text" name="address" value="<?php data("address"); ?>"></td>
        </tr>
        <tr>
            <th><label>Email</label></th>
            <td><input type="text" name="email" value="<?php data("email"); ?>"></td>
            <input type="text" name="num" value="" readonly>
        <tr align="center">
            <td>

            </td>
            <td>
                <input type="submit" name="prev" value="prev">
                <input type="submit" name="next" value="next">
            </td>
        </tr>
    </table>


    <input type="submit" name="insert" value="insert">
    <input type="submit" name="update" value="Update">
    <input type="submit" name="delete" value="Delete">
    <input type="submit" name="searchByName" value="Search By Name">
    <input type="submit" name="showTable" value="Show XML Data">
</form>

</body>
</html>

