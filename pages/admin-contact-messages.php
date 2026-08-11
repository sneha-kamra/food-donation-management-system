<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Handle delete request
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM contact_feedback WHERE id=$id");
    header("Location: admin-contact-messages.php");
    exit;
}

// Handle reply submission
$replySuccess = '';
if(isset($_POST['send_reply'])){
    $id = intval($_POST['id']); // message ID
    $replyText = $conn->real_escape_string($_POST['reply']);
    $conn->query("UPDATE contact_feedback SET reply='$replyText' WHERE id=$id");
    $replySuccess = "Reply saved successfully!";
}

// Fetch messages
$result = $conn->query("SELECT * FROM contact_feedback ORDER BY id DESC");
$totalMessages = $result ? $result->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Contact Messages</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
:root{
--primary:#0f766e;
--accent:#f59e0b;
--text:#0f172a;
--muted:#64748b;
--white:#ffffff;
--card:#ffffff;
--shadow:0 15px 40px rgba(0,0,0,0.08);
--shadow-hover:0 20px 45px rgba(0,0,0,0.12);
--delete-hover:#991b1b;
--reply-hover:#15803d;
}
body{background:linear-gradient(135deg,#f8fafc,#eef6f5);color:var(--text);min-height:100vh;padding:40px 0;}
.container{width:min(1200px,90%);margin:auto;}
.page-header{background:linear-gradient(135deg,var(--primary),var(--accent));color:white;padding:28px;border-radius:22px;margin-bottom:28px;box-shadow:0 12px 35px rgba(15, 118, 110, 0.18);}
.page-header h1{font-size:2rem;font-weight:800;margin-bottom:8px;}
.page-header p{font-size:0.95rem;opacity:0.9;}
.back-btn{display:inline-block;background:var(--accent);color:#111827;text-decoration:none;padding:12px 18px;border-radius:14px;font-weight:700;box-shadow:0 8px 20px rgba(245,158,11,0.25);transition:0.3s ease;margin-bottom:16px;}
.back-btn:hover{transform:translateY(-2px);}
.table-wrapper{background:var(--card);border-radius:24px;overflow:hidden;box-shadow:var(--shadow);}
.table-scroll{overflow-x:auto;}
table{width:100%;border-collapse:collapse;min-width:1100px;}
thead{background:var(--primary);color:white;}
thead th{padding:14px 12px;text-align:left;font-weight:600;font-size:0.92rem;white-space:nowrap;}
tbody tr{border-bottom:1px solid #e2e8f0;transition:0.2s ease;}
tbody tr:hover{background:#f0fdf4;}
tbody td{padding:14px 12px;font-size:0.92rem;vertical-align:top;color:var(--text);}
.name{font-weight:700;}
.small-text{font-size:0.84rem;color:var(--muted);margin-top:4px;}
.actions-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;margin-right:6px;padding:8px 14px;border-radius:10px;font-size:0.85rem;font-weight:600;text-decoration:none;color:white;transition:0.25s ease;border:none;cursor:pointer;}
.reply-btn{background:#16a34a;}
.reply-btn:hover{background:var(--reply-hover);transform:translateY(-2px);}
.delete-btn{background:#dc2626;}
.delete-btn:hover{background:var(--delete-hover);transform:translateY(-2px);}
.empty-state{text-align:center;padding:50px 20px;color:var(--muted);}
.empty-state i{font-size:3rem;color:#d8b4fe;margin-bottom:12px;}
.empty-state h3{color:var(--text);margin-bottom:6px;font-size:1.3rem;}
.modal{display:none;position:fixed;z-index:999;left:0;top:0;width:100%;height:100%;overflow:auto;background:rgba(0,0,0,0.6);}
.modal-content{background:var(--card);margin:10% auto;padding:20px;border-radius:16px;max-width:500px;box-shadow:var(--shadow);}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;}
.modal-header h3{margin:0;}
.close-btn{cursor:pointer;font-size:1.2rem;font-weight:700;color:var(--muted);}
.close-btn:hover{color:var(--text);}
.modal-body textarea{width:100%;padding:10px;margin:6px 0;border-radius:8px;border:1px solid #cbd5e1;font-size:0.9rem;}
.modal-body button{padding:10px 18px;border:none;border-radius:10px;background:#16a34a;color:white;font-weight:600;cursor:pointer;transition:0.3s ease;margin-top:8px;}
.modal-body button:hover{background:var(--reply-hover);}
.success-msg{color:green;margin-bottom:10px;}
@media(max-width:768px){table{min-width:700px;}}
@media(max-width:480px){body{padding:20px 0;}}
.star {
    color: #FFD700; /* Bright gold */
    font-size: 1rem;
    margin-right: 2px;
}
.star-empty {
    color: #ffe680; /* light grey for empty stars */
    font-size: 1rem;
    margin-right: 2px;
}
</style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
        <p>Manage all feedback, complaints, ratings, and inquiries submitted through the website.</p>
    </div>
    <a href="admin-dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    <div style="margin:16px 0;font-weight:600;color:var(--text);">Total Messages: <?php echo $totalMessages; ?></div>

    <?php if($replySuccess) echo "<div class='success-msg'>$replySuccess</div>"; ?>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sender</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject / Type</th>
                        <th>Message</th>
                        <th>Star Rating</th>
                        <th>Reply</th>
                        <th>Submitted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($result && $result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        $id = intval($row['id']);
                        $fullname = htmlspecialchars($row['fullname']);
                        $email = htmlspecialchars($row['email'], ENT_QUOTES);
                        $phone = htmlspecialchars($row['phone']);
                        $subject = htmlspecialchars($row['subject']);
                        $message = htmlspecialchars($row['message']);
                        $reply = isset($row['reply']) ? htmlspecialchars($row['reply']) : '';                        
                        $rating = isset($row['star_rating']) ? intval($row['star_rating']) : 0;
                        $created = htmlspecialchars($row['created_at']);

                        echo "<tr>";
                        echo "<td>#$id</td>";
                        echo "<td class='name'>$fullname</td>";
                        echo "<td class='small-text'>$email</td>";
                        echo "<td class='small-text'>$phone</td>";
                        echo "<td>$subject</td>";
                        echo "<td>".nl2br($message)."</td>";

                        // Visual star rating with golden stars
                       echo "<td>";
                       for($i=1;$i<=5;$i++){
                       if($i <= $rating) {
                       echo "<i class='fas fa-star star'></i>"; // filled gold
                       } else {
                       echo "<i class='fas fa-star star-empty'></i>"; // empty but lighter gold
                       }
                       }
                       echo "</td>";

                        // Reply column
                        echo "<td>".(!empty($reply)?nl2br($reply):"<span style='color:#888'>No reply yet</span>")."</td>";

                        echo "<td>$created</td>";
                        echo "<td>
                                <button class='actions-btn reply-btn' onclick=\"openReplyModal($id,'$reply')\"><i class='fas fa-reply'></i> Reply</button>
                                <a class='actions-btn delete-btn' href='?delete=$id' onclick=\"return confirm('Are you sure you want to delete this message?');\"><i class='fas fa-trash'></i> Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                }else{
                    echo "<tr><td colspan='10'><div class='empty-state'><i class='fas fa-inbox'></i><h3>No Messages Found</h3><p>No contact submissions yet.</p></div></td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal" id="replyModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Reply to Message</h3>
            <span class="close-btn" onclick="closeReplyModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form method="post">
                <input type="hidden" name="id" id="modalID">
                <textarea name="reply" id="modalReply" rows="6" placeholder="Type your reply here..." required></textarea>
                <button type="submit" name="send_reply"><i class="fas fa-paper-plane"></i> Save Reply</button>
            </form>
        </div>
    </div>
</div>

<script>
function openReplyModal(id, reply){
    document.getElementById('modalID').value = id;
    document.getElementById('modalReply').value = reply || '';
    document.getElementById('replyModal').style.display = 'block';
}
function closeReplyModal(){
    document.getElementById('replyModal').style.display = 'none';
}
window.onclick = function(event){
    if(event.target == document.getElementById('replyModal')){
        closeReplyModal();
    }
}
</script>

</body>
</html>

<?php $conn->close(); ?>