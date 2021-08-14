<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("PHPMailer/src/PHPMailer.php");
require_once("PHPMailer/src/Exception.php");
require_once("PHPMailer/src/OAuth.php");
require_once("PHPMailer/src/POP3.php");
require_once("PHPMailer/src/SMTP.php");
require_once("DefaultFunction.php");

class Customer extends connection
{
    var $connection;


    public function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function login($data)
    {
        $func = new DefaultFunction();
        $email = $func->clearString($data['email']);
        $password = md5($func->clearString($data['password']));
        $query = "call procLogin('$email','$password')";
        $result = $this->connection->query($query);
        $user = $result->fetch_assoc();
        if (isset($user)){
            if ($user['uStatus'] == 0 && $user) {
                unset($_SESSION['mail_otp']);
                $_SESSION['user']['uID'] = $user['uID'];
                $_SESSION['user']['uFirstName'] = $user['uFirstName'];
                $_SESSION['user']['uLastName'] = $user['uLastName'];
                $_SESSION['user']['uEmail'] = $user['uEmail'];
                $content = "Khách hàng " . $user['uFirstName'] . " " . $user['uLastName'] . ' - ' . $func->obfuscate_email($user['uEmail']) . ' thực hiện đăng nhập hệ thống thành công!';
                $func->addLog($user['uID'], $content);
                $func->updateLastLogin($user['uID']);
                echo json_encode(array('status' => 1, 'message' => 'Login successful, please wait for the redirect to the homepage.'));
                die();
            } elseif ($user['uStatus'] == 1) {
                echo json_encode(array('status' => 0, 'message' => 'Your account has been locked, please contact support.'));
                die();
            } elseif ($user['uStatus'] == 2) {
                $_SESSION['mail_otp'] = $email;
                if (!$user['uOtpCode']) {
                    $this->getOTP();
                }
                echo json_encode(array('status' => 2, 'message' => 'Your account has not been activated, please activate by OTP code sent to your email.'));
                die();
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Login failed, please check your account information.'));
                die();
            }
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Login failed, please check your account information.'));


    }

    function registerUser($data)
    {
        $time = date("Y-m-d H:i:s");
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phone = $data['phone'];
        $password = $data['password'];
        $sqlGetEmail = "SELECT count(uEmail) as totalEmail from `user` WHERE uEmail = " . "'$email'";
        $result = $this->connection->query($sqlGetEmail);
        $emailOld = $result->fetch_assoc();
        if ((int)$emailOld['totalEmail'] == 1) {
            //$mess = "Email already exists, please use another email.";
            echo json_encode(array('status' => 0, 'message' => 'Email already exists, please use another email.'));
            die();
        } else {
            $sqlInsertUser = "INSERT INTO user(uFirstName, uLastName, uMobile, uEmail, uPassword, uRegisteredAt)";
            $sqlInsertUser .= "VALUES ('$firstName', '$lastName', '$phone', '$email', '$password', '$time')";
            $result = $this->connection->query($sqlInsertUser);
            $id = $this->connection->insert_id;
            if ($result) {
                $_SESSION['mail_otp'] = $email;
                $this->getOTP();
                $clear = new DefaultFunction();
                $content = "Khách hàng " . $firstName . " " . $lastName . ' - ' . $clear->obfuscate_email($email) . ' đã đăng ký tài khoản thành công!';
                $clear->addLog($id, $content);
                echo json_encode(array('status' => 1, 'message' => 'Successful registration, please check your mailbox and activate your account.'));
                die();
            }
        }
    }

    function getOTP()
    {
        $email = $_SESSION['mail_otp'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sqlGetEmail = "SELECT uID,count(uEmail) as totalEmail from `user` WHERE uEmail = '{$email}' and uStatus = 2";
            $this->connection->next_result();
            $result = $this->connection->query($sqlGetEmail);
            $emailOld = $result->fetch_assoc();
            if ($emailOld != 0) {
                $otp = rand(100000, 999999);
                $time = date("Y-m-d H:i:s");
                //uOtpCode,uTimeActiveOtp,uUpdateAt
                $sqlUpdateOtp = "update user set uOtpCode = '{$otp}', uTimeActiveOtp = '{$time}', uUpdateAt = '{$time}' WHERE uEmail = '{$email}'";
                $this->connection->next_result();
                $result = $this->connection->query($sqlUpdateOtp);
                if ($result) {
                    if ($this->sendMailOTP($email, $otp)) {
                        $clear = new DefaultFunction();
                        $content = "Đã gửi mã OTP tới khách hàng " . $clear->obfuscate_email($email);
                        $id = $emailOld['uID'];
                        $clear->addLog($id, $content);
                        echo json_encode(array('status' => 2, 'message' => 'We have sent the OTP code to your email. Please check your mailbox.'));
                        die();
                    }
                    echo json_encode(array('status' => 0, 'message' => 'Send OTP failed.'));
                    die();
                }
                echo json_encode(array('status' => 0, 'message' => 'There was an error while generating the OTP.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'The account does not exist or has been activated.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Please enter your correct account email.'));
    }

    function submitOTP()
    {
        $email = isset($_SESSION['mail_otp']) ? $_SESSION['mail_otp'] : '';
        $clear = new DefaultFunction();
        $otp = $clear->clearString($_POST['otp']);
        //uOtpCode,uTimeActiveOtp,uUpdateAt
        $sql = "select * from user where uEmail = '{$email}' and uOtpCode = '{$otp}'";
        $result = $this->connection->query($sql);
        $otpDetail = $result->fetch_assoc();
        if ($otpDetail) {
            $timeCurr = strtotime(date("Y-m-d H:i:s"));
            $timeOtp = strtotime($otpDetail['uTimeActiveOtp']);
            $diff = abs($timeCurr - $timeOtp);
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
            $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
            if ($minutes > 5) {
                echo json_encode(array('status' => 0, 'message' => 'The OTP code has expired, please get a new OTP code.'));
                die();
            } else {
                $sqlUpdateOtp = "update user set uUpdateAt = '{$timeCurr}', uStatus = 0";
                $this->connection->next_result();
                $result = $this->connection->query($sqlUpdateOtp);
                if ($result) {
                    $clear = new DefaultFunction();
                    $content = "Khách hàng " . $otpDetail['uFirstName'] . " " . $otpDetail['uLastName'] . ' - ' . $clear->obfuscate_email($email) . ' đã kích hoạt tài khoản thành công!';
                    $clear->addLog($otpDetail['uID'], $content);
                    echo json_encode(array('status' => 1, 'message' => 'Account activation successful, you can login to the system now.'));
                    die();
                }
            }
        }
        echo json_encode(array('status' => 0, 'message' => 'The OTP code is not correct, please check again.'));
    }

//    send otp

    function sendMailOTP($email, $otp)
    {
        $mail = new PHPMailer(true);
        $content = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
  <div style="margin:50px auto;width:70%;padding:20px 0">
    <div style="border-bottom:1px solid #eee">
      <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">BoShop</a>
    </div>
    <p style="font-size:1.1em">Hi,</p>
    <p>Thank you for choosing BoShop. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
    <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">' . $otp . '</h2>
    <p style="font-size:0.9em;">Regards,<br />BoShop</p>
    <hr style="border:none;border-top:1px solid #eee" />
    <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
      <p>55 Giai Phong Street,</p>
      <p>Dong Tam Ward,</p>
      <p>Hai Ba Trung District, HN.</p>
    </div>
  </div>
</div>';
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'shoptuanvu.confirm@gmail.com';                 // SMTP username
            $mail->Password = 'gHbrzHX9zxRDYHZ';                           // SMTP password : gHbrzHX9zxRDYHZ
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('noreply.boshop@gmail.com', 'Boshop');
            $mail->addAddress($email);     // Add a recipient
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Your OTP Verification Code at BoShop.';
            $mail->Body = $content;
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            return false;
        }
    }


    function getBillDetail($id, $uID)
    {
        $data = array();
        $sql = "SELECT * FROM (((bill b INNER JOIN bill_details bd ON bd.biID = b.biID) INNER JOIN product_colors pc ON pc.procID = bd.procID) INNER JOIN colors c ON c.coID = pc.coID) INNER JOIN products p ON p.proID = pc.proID WHERE b.biID = '$id' AND b.uID = '$uID'";
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }


    function addLogBuyProduct($user, $nameBill, $activity)
    {
        $time = date("Y-m-d H:i:s");
        $sqlAddLogBuyProduct = "insert into logbuyproduct(nameBill,logBuyContent,uID,logBuyCreateAt) values ('$nameBill','$activity','$user','$time')";
        return $this->connection->query($sqlAddLogBuyProduct);
    }

    function updateLastLogin($id)
    {
        $time = date("Y-m-d H:i:s");
        $sqlUpdateLastLogin = "update user set uLastLogin = " . "'$time'" . " where uID = " . $id;
        if ($result = $this->connection->query($sqlUpdateLastLogin)) {
            return true;
        }
    }


    // check status and isdelete
    function getInfo($id)
    {
        $sqlGetInfo = "CALL findUser($id)";
        $result = $this->connection->query($sqlGetInfo);
        return $user = $result->fetch_assoc();
    }

    function getValueDiscount($discountCode)
    {
        $sqlDiscountCode = "select * from discounts where disCode = " . "'$discountCode'" . " and disStatus = 0 and disIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sqlDiscountCode) or die($this->connection->error);
        return $result->fetch_assoc();
    }

    function getHistory($id)
    {
        $sqlGetHistory = "CALL findBillByUid($id)";
        $data = array();
        $result = $this->connection->query($sqlGetHistory);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }


    function updateInfoUser($data)
    {
        $id = $_SESSION['user']['uID'];
        $clear = new DefaultFunction();
        $uFirstName = $clear->clearString($data['uFirstName']);
        $uLastName = $clear->clearString($data['uLastName']);
        $uMobile = $clear->clearString($data['uMobile']);
        $province = $clear->clearString($data['province']);
        $district = $clear->clearString($data['district']);
        $wards = $clear->clearString($data['wards']);
        $address = $clear->clearString($data['uAddress']);
        $time = date("Y-m-d H:i:s");
        $sqlUpdateInfo = "CALL updateInfoUser($id,'$uFirstName','$uLastName','$uMobile','$address','$province','$district','$wards','$time')";
        if ($this->connection->query($sqlUpdateInfo)) {
            $content = "Khách hàng " . $uFirstName . " " . $uLastName . ' - ' . $clear->obfuscate_email($_SESSION['user']['uEmail']) . ' thực hiện cập nhật thông tin cá nhân thành công!';
            $clear->addLog($_SESSION['user']['uID'], $content);
            echo json_encode(array('status' => 1, 'message' => 'Update info successful!'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Update info fail!'));
    }

    function changePassword($data)
    {
        $time = date("Y-m-d H:i:s");
        //changePasswordByUID IN u_ID int, IN pass varchar(32),IN UpdateAt datetime
        $id = $_SESSION['user']['uID'];
        $currentPassword = $data['currentPassword'];
        $newPassword = $data['newPassword'];
        $confirmPassword = $data['confirmPassword'];
        $sqlGetPassword = "SELECT uPassword FROM `user` WHERE uID = " . "'$id'";
        $result = $this->connection->query($sqlGetPassword);
        $pass = $result->fetch_assoc();
        if ($currentPassword != $pass['uPassword']) {
            $mess = "Please check current password.";
            return false;
        } elseif ($newPassword != $confirmPassword) {
            $mess = "Please check new password and confirm password.";
            return false;
        } else {
            $sqlChangePassword = "CALL changePasswordByUID($id,'$newPassword','$time')";
            if ($result = $this->connection->query($sqlChangePassword)) {
                return true;
            }
        }
    }

    function getPayment()
    {
        $sqlGetPayment = "select * from payment_method where payIsDelete = 0 and payStatus = 0";
        $data = array();
        $result = $this->connection->query($sqlGetPayment);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

//                $idBill = $this->addBill($bi_Name, $currentPrice, $discountValue, $bi_FirstName, $bi_LastName, $bi_Mobile, $bi_Email, $bi_Address, $province, $district, $wards, $bi_CreateAt, $bi_Status, $pay_ID, $uID);
    function addBill($bi_Name, $currentPrice, $discountValue, $bi_FirstName, $bi_LastName, $bi_Mobile, $bi_Email, $bi_Address, $province, $district, $wards, $bi_CreateAt, $bi_Status, $pay_ID, $uID)
    {
        $sqlInsertBill = "INSERT INTO bill(biName,biTotal,biDiscount,biFirstName, biLastName, biMobile, biEmail, biAddress, biProvince, biDistrict, biWards, biCreateAt, biStatus, payID, uID)";
        $sqlInsertBill .= " VALUES ('$bi_Name',$currentPrice,$discountValue,'$bi_FirstName','$bi_LastName','$bi_Mobile','$bi_Email','$bi_Address','$province','$district','$wards','$bi_CreateAt',$bi_Status,$pay_ID,$uID)";
        $this->connection->query($sqlInsertBill);
        return $this->connection->insert_id;
    }

    function addBillDetail($bi_ID, $bid_Price, $bid_Quantity, $proc_ID)
    {
        //insertBillDetail`(IN bid_Quantity int, IN bid_Price int, IN bi_ID int, IN proc_ID int)
        $sqlInsertBillDetail = "CALL insertBillDetail('$bid_Quantity','$bid_Price','$bi_ID','$proc_ID')";
        return $this->connection->query($sqlInsertBillDetail);
    }

    function addLogDiscount($uID, $nameDiscount)
    {
        $time = date("Y-m-d H:i:s");
        $sqlAddLogDiscount = "insert into log_discount(logdisTime,uID,disID) values ('$time','$uID','$nameDiscount')";
        return $this->connection->query($sqlAddLogDiscount);
    }

    function checkQuantityProduct($procID)
    {
        $sqlGetQuantityProduct = "SELECT * FROM product_colors WHERE procID = '$procID'  and procIsDelete = 0 and procStatus = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sqlGetQuantityProduct);
        return $result->fetch_assoc();
    }

    function updateQuantityProduct($procID, $procQuantity)
    {
        $sqlUpdateQuantity = "UPDATE product_colors SET procQuantity = '$procQuantity' WHERE procID = '$procID'";
        return $this->connection->query($sqlUpdateQuantity);
    }

    //update quantity code discount
    function updateQuantityCodeDiscount($disID, $used)
    {
        $sqlUpdateQuantity = "UPDATE discounts SET disUsed = '$used' WHERE disID = '$disID'";
        return $this->connection->query($sqlUpdateQuantity);
    }

    function order($data)
    {
        $func = new DefaultFunction();
        $uID = $_SESSION['user']['uID'];
        $discountCode = $func->clearString($data['discountCode']);
        $paymentCode = $func->clearString($data['payment']);
        // 1. Get Payment method
        $sqlGetPayment = "select * from payment_method where payID = '$paymentCode' and payIsDelete = 0 and payStatus = 0";
        $resultPayment = $this->connection->query($sqlGetPayment);
        $payment = $resultPayment->fetch_assoc();

        //2. Randomly generate invoice name.
        $billName = randomNameBill();

        //3. Get info
        $bi_Name = $billName;
        $user = $this->getInfo($uID);
        // info-order
        $bi_FirstName = $func->clearString($_POST['uFirstName']);
        $bi_LastName = $func->clearString($_POST['uLastName']);
        $bi_Mobile = $func->clearString($_POST['uMobile']);
        $bi_Email = $user['uEmail'];
        $bi_Address = $func->clearString($_POST['uAddress']);
        $province = $func->clearString($_POST['province']);
        $district = $func->clearString($_POST['district']);
        $wards = $func->clearString($_POST['wards']);
        $bi_CreateAt = date("Y-m-d H:i:s");
        $bi_Status = 0;
        $pay_ID = $paymentCode;

        //4. Total bill
        $total = 0;
        foreach ($_SESSION['cart'] as $product) {
            foreach ($product as $pro) {
                $total = $total + $pro['price'] * $pro['numProduct'];
            }
        }
        //5. Check payment method
        if ($payment && $payment['payID'] == $paymentCode) {
            //if discount code other than empty
            if (isset($discountCode) && $discountCode != "") {
                //6. Get discount code
                $codeDetail = $this->getValueDiscount($discountCode);
                //7. Check discount code
                if ($codeDetail != null && ($codeDetail['disCode'] == $discountCode) && ($codeDetail['disAmount'] - $codeDetail['disUsed'] > 0)) {
                    $current_date = date("Y-m-d H:i:s");
                    $disID = $codeDetail['disID'];
                    //8. Get used discount code
                    $sqlCheckLogDiscount = "select count(logdis_ID) as countID from log_discount where disID = '$disID' and uID = '$uID'";
                    $this->connection->next_result();
                    $logDis = $this->connection->query($sqlCheckLogDiscount);
                    $logDisDetail = $logDis->fetch_assoc();
                    //9. Check used discount code
                    if ($logDisDetail && $logDisDetail['countID'] == 0) {
                        $countCode = ($codeDetail['disAmount'] - $codeDetail['disUsed']);
                        if (strtotime($codeDetail['disStart']) <= strtotime($current_date) && strtotime($current_date) <= strtotime($codeDetail['disEnd']) && $countCode > 0) {
                            $discountValue = $total * ($codeDetail['disValue'] / 100);
                            //update quantity code discount
                            $used = $codeDetail['disUsed'] != null ? $codeDetail['disUsed'] : 0;
                            $this->updateQuantityCodeDiscount($disID, $used + 1);
                            //add log discount
                            $this->addLogDiscount($uID, $codeDetail['disID']);
                        } elseif (strtotime($current_date) >= strtotime($codeDetail['disEnd'])) {
                            echo json_encode(array('status' => '1', 'message' => "The discount code has expired."));
                            exit();
                        } elseif ($countCode <= 0) {
                            echo json_encode(array('status' => '1', 'message' => "The number of discount codes has expired."));
                            exit();
                        } else {
                            echo json_encode(array('status' => '1', 'message' => "Discount code applied failed. Please check again."));
                            exit();
                        }
                    } else {
                        echo json_encode(array('status' => '1', 'message' => "You have used this discount code."));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => '1', 'message' => "Please check your discount code."));
                    exit();
                }
            } else {
                $discountValue = 0;
            }
            // fee shipping
            if ($total > 1000) {
                $shipping = 0;
            } else {
                $shipping = 30;
            }
            //vat
            $vat = $total * 0.1;
            $currentPrice = $total + $shipping + $vat;

            //9.2 Check quantity product color
            $checkQuantity = 0;
            foreach ($_SESSION['cart'] as $product) {
                foreach ($product as $pro) {
                    $quantityProductColor = $this->checkQuantityProduct($pro['procID']);
                    if ($quantityProductColor['procQuantity'] > 0) {
                        $checkQuantity = 0;
                    } else {
                        $checkQuantity = 1;
                    }
                }
            }
            //10. Insert bill
            if ($checkQuantity == 0) {
                $idBill = $this->addBill($bi_Name, $currentPrice, $discountValue, $bi_FirstName, $bi_LastName, $bi_Mobile, $bi_Email, $bi_Address, $province, $district, $wards, $bi_CreateAt, $bi_Status, $pay_ID, $uID);
                if ($idBill != 0 && $idBill != null) {
                    //11. Insert detail bill
                    foreach ($_SESSION['cart'] as $product) {
                        foreach ($product as $pro) {
                            //function addBillDetail($bi_ID, $bid_Price, $bid_Quantity, $proc_ID)
                            $this->addBillDetail($idBill, $pro['price'], $pro['numProduct'], $pro['procID']);
                            //update quantity product color
                            //function checkQuantityProduct($procID)
                            $numQuantityCurr = $this->checkQuantityProduct($pro['procID']);
                            $this->updateQuantityProduct($pro['procID'], $numQuantityCurr['procQuantity'] - $pro['numProduct']);
                        }
                    }

                    //add log buy product
                    $activityBuy = "đặt hàng thành công";
                    $this->addLogBuyProduct($uID, $bi_Name, $activityBuy);
                    unset($_SESSION['cart']);
                    echo json_encode(array('status' => '0', 'id' => $idBill, 'message' => "Order successfully, with order number #" . $bi_Name));
                } else {
                    echo json_encode(array('status' => '1', 'message' => "Invoice addition failed, please check order information again."));
                    die();
                }
            } else {
                echo json_encode(array(
                    'status' => '1',
                    'message' => 'Please double check the quantity of the purchased product.'));
                die();
            }
        } else {
            echo json_encode(array('status' => '1', 'message' => "An error occurred with the payment method. Please check again."));
            die();
        }
    }

    function cancel_bill($id)
    {
        // check if the invoice belongs to that account?
        $sqlCheck = "select * from bill where biID = {$id} and uID = {$_SESSION['user']['uID']}";
        $check = $this->connection->query($sqlCheck);
        $detailBill = $check->fetch_assoc();
        if ($detailBill && $detailBill['biStatus'] == 0) {
            $sqlUpdate = "update bill set biStatus = 4 where biID = {$id}";
            $this->connection->next_result();
            $status = $this->connection->query($sqlUpdate);
            if ($status) {
                $func = new DefaultFunction();
                $content = 'Khách hàng hủy đơn hàng <b>#' . $detailBill['biName'] . '</b>';
                $func->addLog($_SESSION['user']['uID'], $content);
                echo json_encode(array('status' => 1, 'message' => 'Order cancel successfully!'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Unsuccessful order cancellation!'));
        }
    }

    //forget password
    function generatePassword($email)
    {
        //check email in database
        $sqlGetEmail = "select uEmail,uStatus from user where uEmail = '$email' and uIsDelete = 0 and uStatus = 0";
        $resultEmail = $this->connection->query($sqlGetEmail);
        $detailEmail = $resultEmail->fetch_assoc();
        if ($detailEmail != null && $detailEmail['uStatus'] == 0) {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz-=~!@#$%^&*()_+,./<>?;:[]{}\|';
            $newPassword = substr(str_shuffle($data), 0, 8);
            //send password to email.
            $sendMail = $this->sendMail($email, $newPassword);

            if ($sendMail) {
                // update password
                $sqlUpdatePassword = "UPDATE user SET uPassword = md5('$newPassword') WHERE uEmail = '$email'";
                $updatePassword = $this->connection->query($sqlUpdatePassword);
                if ($updatePassword) {
                    echo json_encode(array('status' => '1', 'message' => "New password has been sent to your email. Please check your email and log in to the system to use the service."));
                } else {
                    echo json_encode(array('status' => '0', 'message' => "New password generation failed, please check again."));
                }
            }
        } elseif ($detailEmail != null && $detailEmail['uStatus'] == 1) {
            echo json_encode(array('status' => '0', 'message' => "Your account has been suspended. Please contact store support."));
        } else {
            echo json_encode(array('status' => '0', 'message' => "Email does not exist in the system, please check again."));
        }
    }

    // send mail
    function sendMail($email, $password)
    {
        $mail = new PHPMailer(true);
        $content = "New password your at BOSHOP is: " . $password;
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'shoptuanvu.confirm@gmail.com';                 // SMTP username
            $mail->Password = 'gHbrzHX9zxRDYHZ';                           // SMTP password : gHbrzHX9zxRDYHZ
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('noreply.boshop@gmail.com', 'Boshop');
            $mail->addAddress($email);     // Add a recipient
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'The new password at BOSHOP has been updated.';
            $mail->Body = $content;
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            return false;
        }
    }
}

function randomNameBill()
{
    return substr(str_shuffle("QWERTYUIOPASDFGHJKLZXCVBNM0123456789"), 0, 10);
}


