<?php
require_once 'models/userModel.php';

class UserController
{
    public static function userController()
    {

        $users = UserModel::getAllUsersWithRoles();
        require_once 'views/user/user.php';
    }

    public static function addUserController()
    {

        $roles = UserModel::getRoles();
        require_once 'views/user/add-user.php';
    }

    public static function editUserController()
    {
        if (isset($_GET['id'])) {
            $user = UserModel::getUserById($_GET['id']);
            $roles = UserModel::getRoles();
            if ($user) {
                require_once 'views/user/edit-user.php';
            } else {
                echo "Không tìm thấy người dùng.";
            }
        } else {
            echo "ID người dùng không xác định.";
        }
    }


    public static function storeUserController()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                'fullname' => $_POST['fullname'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'role_id' => $_POST['role_id'],
                'status' => isset($_POST['status']) ? 1 : 0,
            ];


            if (isset($_FILES['avata']) && $_FILES['avata']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'Uploads/User/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['avata']['name']);
                $uploadFilePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['avata']['tmp_name'], $uploadFilePath)) {
                    $data['avatar'] = $uploadFilePath;
                } else {
                    echo "Lỗi khi tải lên ảnh.";
                    return;
                }
            } else {
                $data['avatar'] = null;
            }

            if (UserModel::isUsernameExists($data['username'])) {
                echo "Tên người dùng đã tồn tại. Vui lòng chọn tên khác.";
                return;
            }


            if (UserModel::isEmailExists($data['email'])) {
                echo "Email đã tồn tại. Vui lòng chọn email khác.";
                return;
            }


            if (UserModel::addUser($data)) {
                header("Location: index.php?action=user");
                exit();
            } else {
                echo "Lỗi khi thêm người dùng. Kiểm tra lại các thông tin và thử lại.";
            }
        }

        $roles = UserModel::getRoles();
        include 'views/user/add-user.php';
    }



    public static function updateUserController()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_GET['id'],
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'fullname' => $_POST['fullname'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'role_id' => $_POST['role_id'],
                'status' => isset($_POST['status']) ? 1 : 0,
            ];


            if (!empty($_FILES['avatar']['name'])) {
                $uploadDir = 'Uploads/User/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['avatar']['name']);
                $uploadFilePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFilePath)) {
                    $data['avatar'] = $uploadFilePath;
                } else {
                    echo "Lỗi khi tải lên ảnh.";
                    return;
                }
            } else {

                $user = UserModel::getUserById($data['user_id']);
                $data['avatar'] = $user['avatar'];
            }

            if (UserModel::updateUser($data)) {
                header("Location: index.php?action=user");
                exit();
            } else {
                echo "Lỗi: Không thể cập nhật người dùng.";
            }
        }


        if (isset($_GET['id'])) {
            $user = UserModel::getUserById($_GET['id']);
            $roles = UserModel::getRoles();
            require_once 'views/user/edit-user.php';
        }
    }

    public static function deleteUserController()
    {
        UserModel::deleteUser($_GET['id']);
        header("Location: index.php?action=user");
        exit();
    }
}
