<?php
include('connect.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get booking ID from URL
if (isset($_GET['bookingID'])) {
    $bookingID = $_GET['bookingID'];

    // Fetch ticket details
    $sql = "SELECT payment.*, booking.*, showtimes.*, ticket.*, movies.*, users.*, new_theater.*
            FROM payment
            JOIN booking ON payment.bookingID = booking.bookingID
            JOIN showtimes ON booking.showtime_id = showtimes.showtime_id
            JOIN ticket ON booking.bookingID = ticket.bookingID
            JOIN movies ON showtimes.movieID = movies.movieID
            JOIN users ON booking.userID = users.userID
            JOIN new_theater ON showtimes.theater_id = new_theater.theater_id
            WHERE booking.bookingID = '$bookingID' 
              AND booking.userID = '" . $_SESSION['user_id'] . "'";
    
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {

        // Load FPDF library
        require('fpdf186/fpdf.php');

        $pdf = new FPDF();
        $pdf->AddPage();

        // Title
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Movie Ticket',0,1,'C');
        $pdf->Ln(5);

        // Place Image on the RIGHT
        $imgWidth = 60; 
        $xImage = $pdf->GetPageWidth() - $imgWidth - 20; // right side
        $yImage = 40;
        $pdf->Image('admin/uploads/' . $row['image'], $xImage, $yImage, $imgWidth);

        // Ticket Details on LEFT
        $pdf->SetFont('Arial','',12);
        $pdf->SetY($yImage); // align text with image top
        $pdf->SetX(20); // left margin

        $pdf->Cell(60,10,'Movie: ',0,0); $pdf->Cell(0,10,$row['title'],0,1);
        $pdf->SetX(20);
        $pdf->Cell(60,10,'User: ',0,0); $pdf->Cell(0,10,$row['name'],0,1);
        $pdf->SetX(20);
        $pdf->Cell(60,10,'Theater: ',0,0); $pdf->Cell(0,10,$row['tname'],0,1);
        $pdf->SetX(20);
        $pdf->Cell(60,10,'Showtime: ',0,0); $pdf->Cell(0,10,$row['time'],0,1);
        $pdf->SetX(20);
        $pdf->Cell(60,10,'Price: ',0,0); $pdf->Cell(0,10,$row['price'].' BDT',0,1);
        $pdf->SetX(20);
        $pdf->Cell(60,10,'Status: ',0,0); $pdf->Cell(0,10,($row['status']==1 ? "Approved" : "Pending"),0,1);

        // Output as Download
        $pdf->Output('D', 'ticket_'.$row['bookingID'].'.pdf');
        exit();
    } else {
        echo "Ticket not found or unauthorized access.";
    }
} else {
    echo "Invalid request.";
}
