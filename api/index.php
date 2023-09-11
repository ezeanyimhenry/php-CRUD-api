<?php 

include_once("config.php");

// Handle HTTP requests
$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "GET":
        if (isset($_GET["id"])) {
            // Get details of a specific person
            $id = $_GET["id"];
            getPerson($id);
        } else {
            // Get a list of all persons
            getAllPersons();
        }
        break;

    case "POST":
        // Create a new person
        createPerson();
        break;

    case "PUT":
        // Update an existing person
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            updatePerson($id);
        }
        break;

    case "DELETE":
        // Delete a person
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            deletePerson($id);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array("message" => "Method not allowed."));
        break;
}

function getPerson($id)
{
    global $conn;
    $sql = "SELECT * FROM persons WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $person = $result->fetch_assoc();
        if ($person) {
            echo json_encode($person);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "Person not found."));
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error fetching data."));
    }
}

function getAllPersons()
{
    global $conn;
    $sql = "SELECT * FROM persons";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $persons = array();
        while ($row = $result->fetch_assoc()) {
            $persons[] = $row;
        }
        echo json_encode($persons);
    } else {
        echo json_encode(array()); // Return an empty array if no persons found
    }
}

function createPerson()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data["name"];
    $sql = "INSERT INTO persons (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name);
    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(array("message" => "Person created."));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error creating person."));
    }
}

function updatePerson($id)
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data["name"];
    $sql = "UPDATE persons SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $id);
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Person updated."));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error updating person."));
    }
}

function deletePerson($id)
{
    global $conn;
    $sql = "DELETE FROM persons WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Person deleted."));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error deleting person."));
    }
}

// Close the database connection
$conn->close();

?>
