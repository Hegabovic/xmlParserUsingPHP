<?php
session_start();
if (!isset($_SESSION["index"])) {
    $_SESSION["index"] = 0;
    var_dump($_SESSION["index"]);
}

require_once "vendor/autoload.php";

function data($x)
{
    if (isset($_POST[$x])) {
        echo $_POST[$x];
    } else {
        echo " ";
    }
}

/**
 * next button handling
 */

$xml = simplexml_load_file("./Model/EmployeeData.xml") or die("something Wrong");

//var_dump($xml);

$newEmployee = new Employee();
$file = new XmlHandler("./Model/EmployeeData.xml");
$xmlRootElement = $file->readXmlFile();
[$name, $phone, $address, $email] = $newEmployee->navigateEmployee($xmlRootElement, $_SESSION["index"]);
// refactor next
if (isset($_POST["next"])) {
    $_POST['name'] = $name;
    $_POST['phone'] = $phone;
    $_POST['address'] = $address;
    $_POST['email'] = $email;
    $_SESSION["index"] = $_SESSION["index"] + 1;
    if ($_SESSION["index"] >= $xmlRootElement->count()) {
        $_SESSION["index"] = 0;
    }
}

if (isset($_POST["prev"])) {
    $_POST['name'] = $name;
    $_POST['phone'] = $phone;
    $_POST['address'] = $address;
    $_POST['email'] = $email;

//    $_SESSION["index"]= $_SESSION["index"]-1;
    if ($_SESSION["index"] < 0) {
        $_SESSION["index"] = $xmlRootElement->count() - 1;
    }

}
/**
 * insert new element child in XML file
 */
if (isset($_POST['insert'])) {
    $data = [
        "name" => $_POST["name"],
        "phone" => $_POST["phone"],
        "address" => $_POST["address"],
        "Email" => $_POST["email"],
    ];
    $newEmployee->createEmployeeElement($xmlRootElement, $data, "employee");
    $file->saveData($xmlRootElement);
}

/**
 * update an existing field in XML file
 */
if (isset($_POST["update"])) {
    if (isset($_SESSION["index"])) {
        $index = $_SESSION["index"];
        $newEmployee->updateEmployeeElement($xmlRootElement, $index);
        $file->saveData($xmlRootElement);
    }
}

if (isset($_POST["delete"])) {
    if (isset($_SESSION["index"])) {
        $index = $_SESSION["index"];
        $newEmployee->deleteEmployeeElement($xmlRootElement, $index);
    }
    $file->saveData($xmlRootElement);
}
if (isset($_POST["searchByName"])) {
    $key = $_POST["name"];
    $found = 0;
    for ($test = 0; $test < count($xmlRootElement->employee); $test++) {
        if (strcmp($key, $xmlRootElement->employee[$test]->name) == 0) {
            $_SESSION["id"] = $test;
            echo $xmlRootElement->employee[$test]->name;
        }
    }
}

?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="Static/style.css">
        <title>Document</title>
    </head>
    <body>
    <form action="" method="post" class=" form-group ">
        <table class="">
            <tr>
                <th colspan="2"><input type="text" name="num" value="<?= $_SESSION["index"] ?>" style="background-color:#495057;color: #80bdff;" readonly></th>
            </tr>
            <tr >
                <th><label id="name-label" style="color: #485563">Name</label></th>
                <td><input class="inputx" type="text" name="name" value="<?php data("name"); ?>" ></td>
            </tr>
            <tr>
                <th><label id="name-label" style="color: #485563">Phone</label></th>
                <td><input class="inputx" type="text" name="phone" value="<?php data("phone"); ?>"></td>

            </tr>
            <tr>
                <th><label id="name-label" style="color: #485563">Address</label></th>
                <td><input class="inputx" type="text" name="address" value="<?php data("address"); ?>"></td>
            </tr>
            <tr>
                <th><label id="name-label" style="color: #485563">Email</label></th>
                <td><input class="inputx" type="text" name="email" value="<?php data("email"); ?>"></td>
            <tr align="center">
                <td>

                </td>
                <td><br>
                    <input type="submit" name="prev" value="<<" class="btnx color-8">
                    <input type="submit" name="next" value=">>" class="btnx color-8">
                </td>
            </tr>
        </table>

        <div class="button-control">
            <div class="inner1">
                <input type="submit" name="insert" value="insert" class="btn-hover color-8">
                <input type="submit" name="update" value="Update" class="btn-hover color-8">
                <input type="submit" name="delete" value="Delete" class="btn-hover color-8">

            </div>
            <div style="margin-top: 10px;margin-bottom: 10px;">
                <input type="submit" name="searchByName" value="Search By Name" class="btn-hover color-8">
            </div>
            <div>
<!--                <input type="submit" name="showTable" value="Show XML Data" class="btn-hover color-8">-->
            </div>
        </div>
    </form>

    </body>
    </html>
<?php

if (isset($_POST["showTable"])) {
    echo "<table>";
    echo "<tr><th>Name</th><th>Phone</th><th>Address</th><th>Email</th></tr>";
    foreach ($xml->children() as $employee) {
        echo "<tr><td>$employee->name</td>";
        echo "<td>$employee->address</td>";
        echo "<td>$employee->phone</td>";
        echo "<td>$employee->Email</td></tr>";
    }
    echo "</table>";
}
?>