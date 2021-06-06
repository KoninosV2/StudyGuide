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
		$sql1 = "SELECT cat_title FROM lesson_cat, lesson WHERE cat_id = cat_short_title AND lesson_code = ?";
		$stmt = $pdo->prepare($sql1);
		$stmt->execute([$lesson_id]);
		$cat = $stmt->fetch();

		// Προαπαιτούμενα μαθήματος
		$sql = "SELECT requirement_id, group_id 
						FROM lesson_prereq, lesson  
						WHERE lesson.lesson_code = lesson_prereq.lesson_code 
						AND lesson.lesson_code = ? ORDER BY group_id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id]);
		$requirments = $stmt->fetchAll();

		// Τύπος Μαθήματος
		$sql = "SELECT type_title FROM type, type2lesson WHERE type_id = type_short_title AND lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id]);
		$types = $stmt->fetchAll();

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
		$number_of_books = $stmt->rowCount();

		// Καθηγητές Μαθήματος
		if(isset($_SESSION['user_id'])){
			$sql = "SELECT teacher_id FROM teacher2lesson WHERE lesson_code = ?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_id]);
			$teachers_of_lesson = $stmt->fetchAll();
			$is_teacher = false;		
			foreach($teachers_of_lesson as $teacher){
				if($teacher['teacher_id'] == $_SESSION['user_id']){
					$is_teacher = true;
					break;
				}
			}
		}
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
          <div class="card shadow mb-3">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βασικές Πληροφορίες</h4>
          	</div>
          	<div class="card-body">
							<div class="row mb-3">
				        <div class="lesson-category font-weight-bold text-gray-800">Τίτλος(ΕΝ): 
									<span class="font-weight-normal"><?php echo $lesson['title_eng']; ?></span>
								</div>
							</div>
          		<div class="row mb-3">
				        <div class="lesson-category font-weight-bold text-gray-800">Κατηγορία: 
									<span class="font-weight-normal"><?php echo $cat['cat_title']; ?></span>
								</div>
							</div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Μονάδες ECTS: 
									<span class="font-weight-normal"><?php echo $lesson['ects']; ?></span>
								</div>
							</div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Εξάμηνο: 
									<span class="font-weight-normal"><?php echo $lesson['semester']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Προαπαιτούμενα: 
									<span class="font-weight-normal">
										<?php 
										
										echo "(";
										for($i = 0; $i < count($requirments)-1; $i++){
												$sql = "SELECT title FROM lesson WHERE lesson_code = ?";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$requirments[$i]["requirement_id"]]);
												$lesson_title = $stmt->fetch();
												echo  $lesson_title['title'];
												if($requirments[$i + 1]['group_id'] == $requirments[$i]['group_id'])
													echo " ή ";
												else
													echo ") και (";
												if($requirments[$i]['group_id'] == 1)	
													if($i != count($requirments)-1)
														echo "  ";
														//  echo " ή "
													
														
										}	
										if(count($requirments) >= 1){
											$sql = "SELECT title FROM lesson WHERE lesson_code = ?";
											$stmt = $pdo->prepare($sql);
											$stmt->execute([$requirments[count($requirments)-1]["requirement_id"]]);
											$lesson_title = $stmt->fetch();
											echo  $lesson_title['title'];	
											echo ")";
										}else{
											echo ")";
										}
									
										
										?>
									
									</span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Tύπος Μαθήματος: 
									<span class="font-weight-normal">
										<?php
											for($i = 0; $i < count($types); $i++){
												if($i == count($types)-1)
													echo $types[$i]['type_title'] . '.';
												else
													echo $types[$i]['type_title'] . ', ';  
											} 	
										?>
									</span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Γλώσσα Διδασκαλίας: 
									<span class="font-weight-normal"><?php echo $lesson['lang']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Γλώσσα Διδασκαλίας(EN): 
									<span class="font-weight-normal"><?php echo $lesson['lang_en'] != ""? $lesson["lang_en"]: "-"; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Προσφέρεται σε φοιτητές Erasmus: 
									<span class="font-weight-normal"><?php echo $lesson['erasmus']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">URL: 
									<span class="font-weight-normal"><a href="<?php echo $lesson['url'];?>" target="_blank"><?php echo $lesson['url']; ?></a></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Διδακτικές Δραστηριότητες: 
									<span class="font-weight-normal"><?php echo $lesson['teaching_method'] != Null? $lesson['teaching_method']: "-"; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Διδακτικές Δραστηριότητες(EN): 
									<span class="font-weight-normal"><?php echo $lesson['teaching_method_eng'] != Null? $lesson['teaching_method_eng']: "-"; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Περιεχόμενα: 
									<span class="font-weight-normal"><?php echo $lesson['curriculum']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Περιεχόμενα(EN): 
									<span class="font-weight-normal"><?php echo $lesson['curriculum_eng']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Τρόπος Παράδοσης: 
									<span class="font-weight-normal"><?php echo $where_teach['where_title']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Αξιολόγηση: 
									<span class="font-weight-normal"><?php echo str_replace('\%', '%', $lesson['grade_method']); ?></span>
								</div>
			        </div>
			      </div>
						<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
							<div class="mb-3 mr-3">
								<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#basic-info" class="btn btn-warning float-right">Τροποποίηση</a>
							</div>
						<?php endif; ?>
          </div>          	
					
					<!-- Μαθησιακά αποτελέσματα -->
					<div class="card shadow mb-3" id="section-two">
						<div class="card-header">
							<ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">Μαθησιακά Αποτελέσματα</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false">Γενικές ικανότητες που καλλιεργεί το μάθημα</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Μέθοδοι αξιολόγησης</a>
								</li>
								
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="pills-tabContent">
								<!-- Μαθησιακά αποτελέσματα -->
								<div class="tab-pane fade show active" id="pills-profile" role="tabpanel">
									<div class="row mb-3">
										<div class="font-weight-bold text-gray-800">Στο τέλος του μαθήματος ο φοιτητής θα μπορεί: </div>
									</div>
									<div class="row mb-3">
										<?php 
												$aims = explode("item", $lesson['aims']);
												$list = "<ul class='list-group'>";
												foreach($aims as $aim)
													if ($aim != "")
														$list.= "<li class='list-group-item'>" . $aim . "</li>";
												$list .= "</ul>";
												echo $list;
										?>
									</div>
									<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
											<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-two" class="btn btn-warning float-right">Τροποποίηση</a>
									<?php endif; ?>
								</div>

								<!-- Γενικές Ικανότητες που καλλιεργεί το μάθημα -->
								<div class="tab-pane fade" id="pills-home" role="tabpanel">
									<form>
										<div class="form-group">
											<?php
												$sql = "SELECT ability.ability_title, ability.ability_order, ability2lesson.lesson_code 
																FROM ability LEFT JOIN ability2lesson ON ability.ability_short_title = ability2lesson.ability_id 
																and ability2lesson.lesson_code = ?";
												$stmt = $pdo->prepare($sql);
												$stmt->execute([$lesson_id]);
												$row_count = 0;
												while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
											?>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck<?= $row_count; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?> disabled></input>
												<label class="custom-control-label" for="customCheck<?= $row_count; ?>">
												<?= $row['ability_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
											<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-two" class="btn btn-warning float-right">Τροποποίηση</a>
										<?php endif; ?>
									</form>
								</div>

								<!-- Μέθοδοι αξιολόγησης -->
								<div class="tab-pane fade" id="pills-contact" role="tabpanel">
									<form>
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
												<input type="checkbox" class="custom-control-input" id="customCheck<?php echo $row_count; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?> disabled></input>
												<label class="custom-control-label" for="customCheck<?php echo $row_count; ?>">
												<?php echo $row['assessment_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
											<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-two" class="btn btn-warning float-right">Τροποποίηση</a>
									<?php endif; ?>
									</form>
								</div>
							</div>
						</div>	
					</div>

					<!-- Οργάνωση διδασκαλίας και Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών-->
					<div class="card shadow mb-3" id="section-three">
						<div class="card-header">
							<ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-program" role="tab" aria-controls="pills-profile" aria-selected="true">Εβδομαδιαίο Πρόγραμμα</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-organize" role="tab" aria-controls="pills-profile" aria-selected="false">Οργάνωση Διδασκαλίας</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-tech" role="tab" aria-controls="pills-home" aria-selected="false">Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών</a>
								</li>
							
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="pills-tabContent">
								<!-- Εβδομαδιαίο Πρόγραμμα -->
								<div class="tab-pane fade  show active" id="pills-program" role="tabpanel">
									<?php
										$sql = "SELECT * FROM section2lesson WHERE lesson_code = ?";
										$stmt = $pdo->prepare($sql);
										$stmt->execute([$lesson_id]);
										$weeks = $stmt->fetchAll();
										$number_of_weeks = $stmt->rowCount();

										if($number_of_weeks != 0):
									?>
									<table class="table table-striped">
										<thead class="table-primary">
											<tr>
												<th scope="col">Εβδ.</th>
												<th scope="col">Τίτλος Ενότητας</th>
												<th scope="col">Βιβλιογραφία</th>
												<th scope="col">Σύνδεσμος Παρουσίασης</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												
												foreach($weeks as $week){
													echo "<tr>";
													echo "<th scope='row'>{$week['section']}</th>";
													echo "<td>{$week['descr']}</td>";
													echo "<td>{$week['reference']}</td>";
													echo "<td><a href='{$week['url']}' target='_blank'>Διαλέξεις</a></td>";
													echo "</tr>";
												}
											?>
										</tbody>
									</table>
									<?php else: ?>
										<p>Δεν έχει εισαχθει το εβδομαδαίο πρόγραμμα του μαθήματος</p>
									<?php endif; ?>
									<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
											<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-three" class="btn btn-warning float-right">Τροποποίηση</a>
									<?php endif; ?>
								</div>
								<!-- Οργάνωση διδασκαλίας -->
								<div class="tab-pane fade" id="pills-organize" role="tabpanel">
									<div class="row mb-3">
										<ul class="my-list">
											<?php 
													$sql = "SELECT teaching.teaching_title, teaching.teaching_order, teaching2lesson.hours, teaching2lesson.lesson_code
																	FROM teaching LEFT JOIN teaching2lesson ON teaching.teaching_short_title =  teaching2lesson.teaching_id 
																	AND teaching2lesson.lesson_code = ? ORDER BY teaching.teaching_order ASC";
													$stmt = $pdo->prepare($sql);
													$stmt->execute([$lesson_id]);
													$row_count = 0;
													$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
													$total_hours = 0;
													foreach($rows as $row){
														echo "<li>";
														echo "<span class='font-weight-bold'>" . $row['teaching_title'] . "</span>";
														if($row['hours'] == Null)
															echo "<span class='right'>" . "-" . "</span>";
														else{
															echo "<span class='font-weight-bold right'>" . $row['hours'] . " ώρες</span>";
															$total_hours += $row['hours'];
														}
														echo "</li>";
													}
													echo "<li>";
													echo "<span class='font-weight-bold'>Σύνολο</span>";
													echo "<span class='font-weight-bold right'>" . $total_hours . " ώρες</span>";		
											?>		
										</ul>
									</div>
									<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
											<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-three" class="btn btn-warning float-right">Τροποποίηση</a>
									<?php endif; ?>
								</div>
											
								<!-- Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών -->
								<div class="tab-pane fade" id="pills-tech" role="tabpanel">
									<form>
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
												<input type="checkbox" class="custom-control-input" id="customCheck<?= $row_count; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?> disabled></input>
												<label class="custom-control-label" for="customCheck<?= $row_count; ?>">
												<?= $row['tech_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
											<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-three" class="btn btn-warning float-right">Τροποποίηση</a>
										<?php endif; ?>
									</form>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="card shadow mb-3" id="section-four">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βιβλιογραφία</h4>
          	</div>
          	<div class="card-body">
          		<div class="row mb-3">
								<?php if($number_of_books != 0): ?>
									<?php 
												$book_list = "<ul class='list-group'>";
												foreach($books as $book)
													if ($book['id'] === "articles" || $book['id'] === "notes")
														$book_list.= "<li class='list-group-item'>" . $book['title'] . "</li>";
													else{
														$book_details = $book['authors'] . ", " . $book['title'] . ', ' . $book['edition'] . ', ' .	 $book['publisher'] . ', ' . $book['year'] . ', ' . $book['eudoxus_id'];
														$book_list.= "<li class='list-group-item'>" . $book_details . "</li>";
													}
												$book_list .= "</ul>";
												echo $book_list;
										?>
									<?php else: ?>
										<p>Δεν έχει εισαχθει η βιβλιογραφία του μαθήματος</p>
									<?php endif ?>
							</div>
			      </div>
						<?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $is_teacher == true)) : ?>
							<div class="mb-3 mr-3">
								<a href="edit_lesson.php?lesson_id=<?php echo $lesson_id; ?>#section-four" class="btn btn-warning float-right">Τροποποίηση</a>
							</div>
						<?php endif; ?>
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
