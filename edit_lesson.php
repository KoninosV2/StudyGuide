<?php
	include 'includes/dbcon.php';
?>

<?php
	if(isset($_GET['lesson_id'])){
		$lesson_id = $_GET['lesson_id'];

		// Παίρνουμε τα δεδομένα του μαθήματος από τον πίνακα lesson
		$sql = "SELECT * FROM lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id]);
		$lesson = $stmt->fetch();


		// Κατηγορία μαθήματος
		$sql = "SELECT * FROM lesson, lesson_cat WHERE cat_id = cat_short_title AND lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id]);
    $category = $stmt->fetch();
    $category_title = $category['cat_title'];

		// Τύπος Μαθήματος
		$sql = "SELECT type_title, type_short_title FROM type, type2lesson WHERE type_id = type_short_title AND lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id]);
		$lesson_type = $stmt->fetch();

		// Tόπος διδασκαλίας
		$sql = "SELECT where_title FROM whereteaching, lesson WHERE where_id = where_short_title AND lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id]);
		$where_teach = $stmt->fetch();

		// Βιβλιογραφία μαθήματος
		$sql = "SELECT * FROM (
						SELECT * FROM book, book2lesson WHERE book_id = id AND lesson_code = ? 
						UNION
						SELECT * FROM book, book2lesson_en WHERE book_id = id AND lesson_code = ?
						) a
						order by book_order";

		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id, $lesson_id]);
		$books = $stmt->fetchAll();
	}
?>
<?php include "includes/header.php";?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
							<?php echo $lesson['title'];?> [<?php echo $lesson['lesson_code']; ?>]
						</h1>
          </div>
          <div class="card shadow border-warning mb-3">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βασικές Πληροφορίες</h4>
          	</div>
          	<div class="card-body edit-lesson">
              <form action="includes/handle_edit_lesson.php" method="POST">
								<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="category" class="col-form-label font-weight-bold text-gray-800">Κατηγορία:</label>
                    <select class="form-control" name="category" id="category">
                      <?php 
                        // Κατηγορία μαθήματος
                        $sql = "SELECT * FROM lesson_cat";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $categories = $stmt->fetchAll();

                        foreach($categories as $cat){
                          if($category_title === $cat['cat_title'])
                            echo "<option value={$cat['cat_short_title']} selected>{$cat['cat_title']}</option>";
                          else
                            echo "<option value={$cat['cat_short_title']}>{$cat['cat_title']}</option>";
                        }
                      ?>
                    </select>
                  </div>
									<div class="form-group col-md-4">
										<label for="ects" class="col-form-label font-weight-bold text-gray-800">Μονάδες ECTS:</label>
										<input type="text" name="ects" class="font-weight-normal form-control" value="<?php echo $lesson['ects']; ?>">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-4">
										<label for="semester" class="col-form-label font-weight-bold text-gray-800">Εξάμηνο:</label>
										<input type="text" name="semester" class="font-weight-normal form-control" value="<?php echo $lesson['semester']; ?>">
									</div>
									<div class="form-group col-md-4">
										<label for="lesson-type" class="col-form-label font-weight-bold text-gray-800">Τύπος Μαθήματος:</label>
										<select class="form-control" id="lesson-type" name="lesson-type">
                      <?php 
												// Όλοι οι τύποι μαθήματος
                        $sql = "SELECT type_title, type_short_title FROM type";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $types = $stmt->fetchAll();

                        foreach($types as $type){
                          if($lesson_type['type_title'] === $type['type_title'])
                            echo "<option value={$type['type_short_title']} selected>{$type['type_title']}</option>";
                          else
                            echo "<option value={$type['type_short_title']}>{$type['type_title']}</option>";
                        }
                      ?>
                    </select>
									</div>
									<div class="form-group col-md-4">
										<label for="language" class="col-form-label font-weight-bold text-gray-800">Γλώσσα Διδασκαλίας:</label>
										<input type="text" name="language" class="font-weight-normal form-control" value="<?php echo $lesson['lang']; ?>">
									</div>
			        	</div>

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="erasmus" class="col-form-label font-weight-bold text-gray-800">Προσφέρεται σε φοιτητές Erasmus:</label>
										<input type="text" name="erasmus" class="font-weight-normal form-control" value="<?php echo $lesson['erasmus']; ?>">
									</div>
									<div class="form-group col-md-6">
										<label for="url" class="col-form-label font-weight-bold text-gray-800">URL:</label>
										<input type="text" name="url" class="font-weight-normal form-control" value="<?php echo $lesson['url']; ?>"> 
									</div>
			        	</div>
								<div class="form-group">	
									<label for="teaching-methods" class="col-form-label font-weight-bold text-gray-800">Διδακτικές Δραστηριότητες:</label>
									<textarea class="form-control" name="teaching-methods" id="teaching-methods" cols="80" rows="5"><?php echo $lesson['teaching_method'] != Null? $lesson['teaching_method']: "-"; ?>
									</textarea>
								</div>
								<div class="form-group">
									<label for="curriculum" class="col-form-label font-weight-bold text-gray-800">Περιεχόμενα:</label>
									<textarea class="form-control" name="curriculum" id="curriculum" cols="80" rows="8"><?php echo $lesson['curriculum']; ?></textarea>
								</div>
								<div class="form-group">
									<label for="where-teaching" class="col-form-label font-weight-bold text-gray-800">Τρόπος Παράδοσης:</label> 
									<select class="form-control" name="where-teaching" id="where-teaching">
										<?php 
											// Όλα τα μέρη διδιασκαλίας
                      $sql = "SELECT where_title, where_short_title FROM whereteaching";
                      $stmt = $pdo->prepare($sql);
                      $stmt->execute();
                      $where_teaching = $stmt->fetchAll();

                      foreach($where_teaching as $wt){
                        if($where_teach['where_title'] === $wt['where_title'])
                          echo "<option value={$wt['where_short_title']} selected>{$wt['where_title']}</option>";
                        else
                          echo "<option value={$wt['where_short_title']}>{$wt['where_title']}</option>";
                      }
                    ?>
									</select>
								</div>
								<div class="form-group">
									<label for="grade-method" class="font-weight-bold text-gray-800 col-form-label">Αξιολόγηση:</label>
									<textarea class="form-control" name="grade-method" id="grade-method" cols="80" rows="5"><?php echo str_replace('\%', '%', $lesson['grade_method']); ?>
									</textarea>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<select class="form-control" name="prereq_lesson" id="prereq_lesson">
											<?php 
												// Όλα τα μαθήματα
												$sql = "SELECT lesson_code, title FROM lesson";
												$stmt = $pdo->prepare($sql);
												$stmt->execute();
												$lessons = $stmt->fetchAll();

												foreach($lessons as $lesson){
													echo "<option value={$lesson['lesson_code']}>{$lesson['title']}</option>";
												}
											?>
										</select>
									</div>
									<div class="form-group col-md-3">
										<select class="form-control" name="group" id="group">
											<option value="0">OΜΑΔΑ Α</option>
											<option value="1">ΟΜΑΔΑ Β</option>
										</select>
									</div>
									<div class="form-group col-md-3">
										<button type="button" id="insert_prereq_lesson_btn" class="btn btn-success">Προσθήκη</button>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<ul id='alpha_team' class='list-group team_lists'>
										  <h5 class="font-weight-bold text-gray-800">ΟΜΑΔΑ Α</h5>
											<?php
											  // Προαπαιτούμενα μαθήματος Α ομάδας
												$sql = "SELECT requirement_id, requirement_order 
												FROM lesson_prereq, lesson  
												WHERE lesson.lesson_code = lesson_prereq.lesson_code 
												AND lesson.lesson_code = ? AND group_id = ?
												ORDER BY requirement_order ASC";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$lesson_id, 0]);
												$group_a_lessons_id = $stmt->fetchAll();
												foreach($group_a_lessons_id as $lesson){
													$sql = "SELECT lesson_code, title FROM lesson WHERE lesson_code = ?";
													$stmt = $pdo->prepare($sql);
													$stmt->execute([$lesson['requirement_id']]);
													$group_a_lessons = $stmt->fetch();
													echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $group_a_lessons['title'];
													echo "<input type='text' name='group_a_lessons[]' value='{$group_a_lessons['lesson_code']}' hidden>";
													echo "<i class='fas fa-trash-alt delete-item'></i>";
													echo "</li>";								
												}
											?>
										</ul>
									</div>
									<div class="form-group col-md-6">
										<ul id='beta_team' class='list-group team_lists'>
										  <h5 class="font-weight-bold text-gray-800">ΟΜΑΔΑ Β</h5>
											<?php 
												// Προαπαιτούμενα μαθήματος Α ομάδας
												$sql = "SELECT requirement_id, requirement_order 
												FROM lesson_prereq, lesson  
												WHERE lesson.lesson_code = lesson_prereq.lesson_code 
												AND lesson.lesson_code = ? AND group_id = ?
												ORDER BY requirement_order ASC";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$lesson_id, 1]);
												$group_b_lessons_id = $stmt->fetchAll();
												foreach($group_b_lessons_id as $lesson){
													$sql = "SELECT lesson_code, title FROM lesson WHERE lesson_code = ?";
													$stmt = $pdo->prepare($sql);
													$stmt->execute([$lesson['requirement_id']]);
													$group_b_lessons = $stmt->fetch();
													echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $group_b_lessons['title'];
													echo "<input type='text' name='group_b_lessons[]' value='{$group_b_lessons['lesson_code']}' hidden>";
													echo "<i class='fas fa-trash-alt delete-item'></i>";
													echo "</li>";								
												}
											?>
										</ul>
									</div>
								</div>
								<button type="submit" name="basic-info-update" class="btn btn-primary float-right">Ενημέρωση</button>
              </form>
			      </div>
          </div>          	
					
					<!-- Μαθησιακά αποτελέσματα -->
					<div class="card shadow mb-3 border-warning">
						<div class="card-header">
							<ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Γενικές ικανότητες που καλλιεργεί το μάθημα</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Μαθησιακά Αποτελέσματα</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Μέθοδοι αξιολόγησης</a>
								</li>
								
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="pills-tabContent">
								<!-- Γενικές Ικανότητες που καλλιεργεί το μάθημα -->
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel">
									<form method="POST" action="includes/handle_edit_lesson.php">
										<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>
										<div class="form-group">
											<?php
												$sql = "SELECT ability.ability_title, ability.ability_order, ability.ability_short_title, ability2lesson.lesson_code
																FROM ability LEFT JOIN ability2lesson ON ability.ability_short_title = ability2lesson.ability_id 
																and ability2lesson.lesson_code = ?";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$lesson_id]);
												$row_count = 0;
												while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
											?>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="ability[]" id="customCheck<?= $row_count; ?>"
															value="<?php echo $row['ability_short_title']; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?> ></input>
												<label class="custom-control-label" for="customCheck<?= $row_count; ?>">
												<?= $row['ability_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<button type="submit" name="update-abilities" class="btn btn-primary float-right">Ενημέρωση</button>
									</form>
								</div>
								<!-- Μαθησιακά αποτελέσματα -->
								<div class="tab-pane fade" id="pills-profile" role="tabpanel">
									<div class="row mb-3">
										<form>
											<div class="form-group">	
												<label for="new_result" class="col-form-label font-weight-bold text-gray-800">Μαθησιακά Αποτελέσματα:</label>
												<textarea class="form-control" id="new_result" cols="120" rows="4"></textarea>	
											</div>
											<button type="button" id="addBtn" class="btn btn-success float-right mb-3">Προσθήκη</button>
										</form>
									</div>
									<div class="row mb-3">
										<div class="font-weight-bold text-gray-800">Στο τέλος του μαθήματος ο φοιτητής θα μπορεί: </div>
									</div>
									<div class="row mb-3">
										<form method="POST" action="includes/handle_edit_lesson.php">
											<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>
											<ul id='items' class='list-group'>
												<?php 
														if(isset($aims)){
															$aims = explode("item", $lesson['aims']);
															foreach($aims as $aim){
																if ($aim != ""){
																	echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $aim;
																	echo "<textarea type='text' name='course_results[]' hidden>{$aim}</textarea>";
																	echo "<i class='fas fa-trash-alt delete-item'></i>";
																	echo "</li>";
																}														
															}
														}
														
												?>
											</ul>
											<button type="submit" name="update-course-results" class="btn btn-primary float-right mt-3">Ενημέρωση</button>
										</form>	
									</div>
								</div>

								<!-- Μέθοδοι αξιολόγησης -->
								<div class="tab-pane fade" id="pills-contact" role="tabpanel">
									<form method="POST" action="includes/handle_edit_lesson.php">
										<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>
										<div class="form-group">
											<?php
												$sql = "SELECT assessment.assessment_title, assessment.assessment_short_title, assessment2lesson.lesson_code 
																FROM assessment LEFT JOIN assessment2lesson ON assessment.assessment_short_title =  assessment2lesson.assessment_id 
																AND assessment2lesson.lesson_code = ?";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$lesson_id]);
												$row_count = 0;
												while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
											?>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="assessment[]" id="assessmentCheck<?php echo $row_count; ?>"
												value="<?php echo $row['assessment_short_title']; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?>></input>
												<label class="custom-control-label" for="assessmentCheck<?php echo $row_count; ?>">
												<?php echo $row['assessment_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<button type="submit" name="update-assessments-methods" class="btn btn-primary float-right">Ενημέρωση</button>
									</form>
								</div>
							</div>
						</div>	
					</div>

					<!-- Οργάνωση διδασκαλίας και Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών-->
					<div class="card shadow mb-3 border-warning">
						<div class="card-header">
							<ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-tech" role="tab" aria-controls="pills-home" aria-selected="true">Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-organize" role="tab" aria-controls="pills-profile" aria-selected="false">Οργάνωση Διδασκαλίας</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="pills-tabContent">
								<!-- Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών -->
								<div class="tab-pane fade show active" id="pills-tech" role="tabpanel">
									<form method="POST" action="includes/handle_edit_lesson.php">
										<input type="text" name="lesson_code" value="<?php echo $lesson_id; ?>" hidden>
										<div class="form-group">
											<?php
												$sql = "SELECT tech.tech_title, tech.tech_short_title, tech2lesson.lesson_code 
																FROM tech LEFT JOIN tech2lesson ON tech.tech_short_title =  tech2lesson.tech_id 
																AND tech2lesson.lesson_code = ?";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$lesson_id]);
												$row_count = 0;
												while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
											?>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="tech[]" id="techCheck<?= $row_count; ?>"
												value="<?php echo $row['tech_short_title']; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?>></input>
												<label class="custom-control-label" for="techCheck<?= $row_count; ?>">
												<?= $row['tech_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<button type="submit" name="update-tech-methods" class="btn btn-primary float-right">Ενημέρωση</button>
									</form>
								</div>
								<!-- Οργάνωση διδασκαλίας -->
								<div class="tab-pane fade" id="pills-organize" role="tabpanel">
									<div class="row mb-3">
										<form action="includes/handle_edit_lesson.php" method="POST">
											<input type="text" name="lesson_code" value="<?php echo $lesson_id; ?>" hidden>
											<?php
													$names = ["lecture", "seminar", "exercise_lab", "field_exercise", "bibliography", 
																		"coaching_school", "practise", "clinic", "artistic_lab", "interactive_teaching",
																		"educational_visit", "project", "assessment", "artistic", "unorder_study"]; 
													$sql = "SELECT teaching.teaching_title, teaching.teaching_order, teaching2lesson.hours, teaching2lesson.lesson_code
																	FROM teaching LEFT JOIN teaching2lesson ON teaching.teaching_short_title =  teaching2lesson.teaching_id 
																	AND teaching2lesson.lesson_code = ? ORDER BY teaching.teaching_order ASC";
													$stmt = $pdo->prepare($sql);
													$stmt->execute([$lesson_id]);
													$row_count = 0;
													$rows = $stmt->fetchAll();
													$total_hours = 0;
													$cnt = 0;
													foreach($rows as $row){
														if($cnt === 0)
															echo "<div class='form-row'>";
														echo "<div class='form-group col-md-4'>";
														echo "<label class='col-form-label font-weight-bold text-gray-800'>{$row['teaching_title']}</label>";
														echo "<input type='text' name='{$names[$cnt]}' class='font-weight-normal form-control' value='{$row['hours']}'>";
														echo "</div>";
														
														if($cnt === 2 ){
															echo "</div>";
															echo "<div class='form-row'>";
														}
														$cnt += 1;
														$total_hours += $row['hours'];
													}
													echo "</div>";
													echo "<span class='font-weight-bold'>Σύνολο: </span>";
													echo "<span class='font-weight-bold right'>" . $total_hours . " ώρες</span>";
													
											?>	
											<button type="submit" name="update-organize-teaching" class="btn btn-primary float-right">Ενημέρωση</button>
										</form>
									</div>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="card shadow border-warning mb-3">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βιβλιογραφία</h4>
          	</div>
          	<div class="card-body">
							<!-- <div class="row mb-3">
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#form">
									Προσθήκη Βιβλιογραφίας
								</button>  
							</div> -->
          		<div class="row mb-3">
								<form method="POST" action="includes/handle_edit_lesson.php">
									<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>
									<div class="form-row">	
										<div class="form-group col-md-10">
                    	<select class="form-control" name="insert_bibliography" id="insert_bibliography">
												<?php 
													// Κατηγορία μαθήματος
													$sql = "SELECT * FROM book";
													$stmt = $pdo->prepare($sql);
													$stmt->execute();
													$bibliography = $stmt->fetchAll();

													foreach($bibliography as $bibl_book){
														echo "<option value={$bibl_book['id']}>
															{$bibl_book['title']} {$bibl_book['authors']} {$bibl_book['publisher']} {$bibl_book['year']} {$bibl_book['eudoxus_id']} {$bibl_book['isbn']}
														</option>";
													}
												?>
                    	</select>
                  	</div>
										<div class="form-group col-md-2">	
											<button type="button" id="insert_bibliography_btn" class="btn btn-success">Προσθήκη</button>
										</div>
									</div>
									<div >
										<ul id='bookItems' class='list-group'>
											<?php 
												foreach($books as $book){
													if($book['id'] === "articles" || $book['id'] === "notes"){
														echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $book['title'];
														echo "<textarea type='text' name='books_update[]' hidden>{$book['id']}</textarea>";
														echo "<i class='fas fa-trash-alt delete-item'></i>";
														echo "</li>";
													}else{
														$book_details = $book['title']. " " .$book['authors']. " " .$book['edition']. " " .$book['publisher']. " " .$book['year']. " " .$book['eudoxus_id'];
														echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $book_details;
														echo "<textarea type='text' name='books_update[]' hidden>{$book['id']}</textarea>";
														echo "<i class='fas fa-trash-alt delete-item ml-3'></i>";
														echo "</li>";
													}												
												}
											?>
										</ul>
									<div>
									<button type="submit" name="update-books" class="btn btn-primary float-right mt-3">Ενημέρωση</button>
								</form>	
							</div>
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
<script src="js/main.js"></script>
