<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <?php
        session_start();

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if (!empty($id)) {
            $conn = new mysqli("localhost", "root", "Root@123", "isms_db");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }

            if($result->num_rows > 0){
                foreach($result->fetch_array() as $k => $v){
                
                    if(!is_numeric($k) && $k != 'password'){
                        $this->settings->set_userdata($k,$v);
                    }

                }
                $this->settings->set_userdata('login_type',1);
            }

            // header('Location: admin/index.php', true, 200);
            // redirect('admin');		
            // header("Location: /isms/admin/index.php");
            $stmt->close();
            $conn->close();

            exit(); 
        } else {
            echo "ID not provided.";
        }
        ?>


    </div>
</body>
</html>

