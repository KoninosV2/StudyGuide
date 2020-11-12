<?php
  include 'includes/dbcon.php';
?>

<?php
  if(isset($_GET['category_id'])){
    $category_id = $_GET['category_id'];
  }
?>
<?php include "includes/header.php"; ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <div class="my-3">
        <h1 class="h3 mb-0 text-gray-800">Λίστα Μαθημάτων</h1>
      </div>
      <!-- Πίνακας Μαθημάτων -->
      <div class="shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Μαθήματα Κορμού</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                <thead>
                  <tr>
                    <th>Τίτλος</th>
                    <th>Εξάμηνο</th>
                    <th>Μονάδες ECTS</th>
                    <th>Θεωρία</th>
                    <th>Εργαστήριο</th>
                    <th>Φροντιστήριο</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση Λίστας Μαθημάτων -->
                  <?php
                    $sql = "SELECT * FROM lesson WHERE cat_id = ?";
						        $stmt = $pdo->prepare($sql);
                    $stmt->execute([$category_id]);
                    $lessons = $stmt->fetchAll();
                    foreach($lessons as $lesson): 
                  ?>  
                      <tr>
                        <td><a href="lesson.php?lesson_id=<?php echo $lesson['lesson_code']; ?>" class="text-gray-600"><?php echo $lesson['title']; ?></a></td>
                        <td><?php echo $lesson['semester']; ?></td>
                        <td><?php echo $lesson['ects']; ?></td>
                        <td><?php echo $lesson['hours_teaching']; ?></td>
                        <td><?php echo ($lesson['hours_lab'] != 0)?:'-' ; ?></td>
                        <td><?php echo ($lesson['hours_exer'] !=0)?:'-'; ?></td>
                      </tr>
					          <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
      <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->
<?php include "includes/footer.php"; ?>
<script>
  $(document).ready( function () {
    $('#dataTable').DataTable();
	});

  $('tbody>tr').click( function() {
    window.location = $(this).find('a').attr('href');
    }).hover( function() {
    $(this).toggleClass('hover');
  });
</script>