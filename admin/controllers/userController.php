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
    public static function searchUsersController()
    {
        $keyword = $_GET['keyword'] ?? '';
        $role = $_GET['role'] ?? '';

        $userModel = new UserModel();
        $users = $userModel->searchUsers($keyword, $role);
        require_once 'views/user/user.php';
    }

    public static function storeUserController()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validate required fields
                if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                    throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
                }

                // Validate avatar selection
                if (empty($_POST['avatar'])) {
                    throw new Exception("Vui lòng chọn ảnh đại diện");
                }

                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                    'fullname' => $_POST['fullname'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'role_id' => $_POST['role_id'],
                    'status' => isset($_POST['status']) ? 1 : 0,
                    'avatar' => $_POST['avatar']
                ];

                // Check if username exists
                if (UserModel::isUsernameExists($data['username'])) {
                    throw new Exception("Tên người dùng đã tồn tại. Vui lòng chọn tên khác.");
                }

                // Check if email exists
                if (UserModel::isEmailExists($data['email'])) {
                    throw new Exception("Email đã tồn tại. Vui lòng chọn email khác.");
                }

                // Define PATH_ROOT if not already defined
                if (!defined('PATH_ROOT')) {
                    define('PATH_ROOT', dirname(dirname(__DIR__))); // Goes up two levels from the controller
                }

                // Verify that the selected image exists
                $imagePath = PATH_ROOT . '/' . $data['avatar'];
                if (!file_exists($imagePath)) {
                    throw new Exception("Ảnh đã chọn không tồn tại trong hệ thống");
                }

                if (UserModel::addUser($data)) {
                    $_SESSION['success'] = "Thêm người dùng thành công";
                    header("Location: index.php?action=user");
                    exit();
                } else {
                    throw new Exception("Lỗi khi thêm người dùng vào cơ sở dữ liệu");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: index.php?action=addUser");
                exit();
            }
        }

        $roles = UserModel::getRoles();
        include 'views/user/add-user.php';
    }

    public static function viewUserController()
    {
        if (isset($_GET['id'])) {
            $user = UserModel::getUserById($_GET['id']);
            if ($user) {
                require_once 'views/user/user-detail.php';
            } else {
                echo "Không tìm thấy người dùng.";
            }
        } else {
            echo "ID người dùng không xác định.";
        }
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
                'avatar' => $_POST['avatar']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }

            if (UserModel::updateUser($data)) {
                header("Location: index.php?action=user");
                exit();
            } else {
                $_SESSION['error'] = "Lỗi: Không thể cập nhật người dùng.";
                header("Location: index.php?action=editUser&id=" . $data['user_id']);
                exit();
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

    public static function userDetailController()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }

            $id = $_GET['id'];
            $user = UserModel::getUserById($id);
            if (!$user) {
                throw new Exception('Không tìm thấy tài khoản');
            }

            require_once './views/user/user-detail.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=user');
            exit();
        }
    }
}
