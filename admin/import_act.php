<?php
include 'conn.php';
include 'excel_reader2.php';
?>

<?php
$target = basename($_FILES['teacherfile']['name']);
move_uploaded_file($_FILES['teacherfile']['tmp_name'], $target);
chmod($_FILES['teacherfile']['name'], 0777);
$data = new Spreadsheet_Excel_Reader($_FILES['teacherfile']['name'], false);
// menghitung jumlah baris data yang ada
$baris = $data->rowcount($sheet_index = 0);

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i = 2; $i <= $baris; $i++) {
//       membaca data (kolom ke-1 sd terakhir)
    $studid = $data->val($i, 1);
    $studno = $data->val($i, 2);
    $firstname = $data->val($i, 3);
    $lastname = $data->val($i, 4);
    $gender = $data->val($i, 5);
    $password = $data->val($i, 6);
//      setelah data dibaca, masukkan ke tabel pegawai sql
    if ($studid != "" && $studno != "" && $firstname != "" && $lastname != "" && $gender != "" && $password != "") {
        // input data ke database (table data_pegawai)
        //$query = ($conn, "INSERT into student (stud_id,stud_no,firstname,lastname,gender,password) values('$studid','$studno','$firstname','$lastname', '$gender', '$password')");
        //$hasil = mysql_query($query);
        mysqli_query($conn, "INSERT into student values('','$studno','$firstname','$lastname','$gender','$password')");
        //mysqli_query($conn,"INSERT into student values('$studid','$studno','$firstname','$lastname', '$gender', '$password')";

        $md5pass = md5($password);
        $update = mysqli_query($conn, "UPDATE student set password='$md5pass' WHERE stud_no = $studno");

        $berhasil++;
        //$updatepass = mysqli_query($conn, )
    }
    // $select = "SELECT * FROM student";
    // $query_select = mysqli_query($conn, $select);
    // while ($row = mysqli_fetch_array($query_select)) {
    //     $update = "UPDATE student set password = md5('" . $row['password'] . "') WHERE stud_no = '" . $row['stud_no'] . "'";
    // }

    //$query = "INSERT into student (stud_id,stud_no,firstname,lastname,gender,password)values('$studid','$studno','$firstname','$lastname', '$gender', '$password')";
    //$hasil = mysql_query($query);
}
header("location:import.php?berhasil=$berhasil");
?>