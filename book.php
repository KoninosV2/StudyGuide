<?php
	include 'includes/dbcon.php';
?>

<?php
	if(isset($_GET['book_id'])){
    $book_id = $_GET['book_id'];
    $sql = "SELECT * FROM book WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
	}
?>


<?php include "includes/header.php";?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
							<?php echo $book['title'];?>
						</h1>
          </div>
          <div class="card shadow border-warning mb-3">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βασικές Πληροφορίες</h4>
          	</div>
          	<div class="card-body">
          		<div class="row mb-3">
				        <div class="lesson-category font-weight-bold text-gray-800">Κωδικός: 
									<span class="font-weight-normal"><?php echo $book['id']; ?></span>
								</div>
							</div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Τίτλος: 
									<span class="font-weight-normal"><?php echo $book['title']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Συγγραφέας: 
                  <span class="font-weight-normal"><?php echo $book['authors']; ?></span>
								</div>
			        </div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Έκδοση: 
									<span class="font-weight-normal"><?php echo $book['edition']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Έτος Έκδοσης: 
									<span class="font-weight-normal"><?php echo $book['year']; ?></span>
								</div>
			        </div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Εκδότης: 
                  <span class="font-weight-normal"><?php echo $book['publisher']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">ISBN: 
									<span class="font-weight-normal"><?php echo $book['isbn']; ?></span>
								</div>
			        </div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Κωδικός στον Εύδοξο: 
									<span class="font-weight-normal"><?php echo $book['eudoxus_id']; ?></span>
								</div>
							</div>
              <a href="admin_books.php?book_id=<?php echo $book['id']; ?> " class="btn btn-danger float-right" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις το συγκεκριμένο βιβλίο;');">Διαγραφή</a>
              <a href="edit_book.php?book_id=<?php echo $book['id']; ?> " class="btn btn-primary float-right mr-3">Ενημέρωση</a>
			      </div>
          </div>          	
					<!-- /.container-fluid -->
				</div>										
    	</div>
    <!-- End of Main Content -->
<?php include "includes/footer.php"; ?>    

<script>
	  $(document).ready( function () {
    	$('#dataTable').DataTable();
	  } );
	  $( "#ability_button" ).click(function() {
		  $('[id^="customCheck"]').prop('disabled', false);
		  this.attr('id','ability_button_editing')
		  this.toggleClass('bu')
	  });
  </script>
