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
    $_SESSION["index"]= $_SESSION["index"]+1;
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
    $changeName = $_POST["name"];
    $changePhone = $_POST["phone"];
    $changeAddress = $_POST["address"];
    $changeEmail = $_POST["email"];
    if (isset($_POST['num'])) {
        $index = $_POST["num"] + 1;
        $xml->employee[$_SESSION["index"]]->name = $changeName;
        $xml->employee[$_SESSION["index"]]->phone = $changePhone;
        $xml->employee[$_SESSION["index"]]->address = $changeAddress;
        $xml->employee[$_SESSION["index"]]->Email = $changeEmail;
        $xml->asXML("EmployeeData.xml");
    }
}

//if(isset($_POST["delete"])){
//    unset($xmlRootElement->employee[$_SESSION["index"]]);
//}
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
                <input type="text" name="num" value="<?=  $_SESSION["index"] ?>" readonly>
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