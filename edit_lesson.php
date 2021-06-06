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

<?php
	if(isset($_POST['new-tech'])){
		$lesson_id = $_POST['lesson-id'];
		$title = $_POST['tech-title'];
		$title_eng = $_POST['tech-title-eng'];

		$sql = "SELECT tech_short_title, tech_order FROM tech ORDER BY tech_order DESC LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetch();
		$tech_order = $results['tech_order'] +1;
		$tech_sort_title = "αλλο-" . $tech_order;

		$sql = "INSERT INTO tech (tech_title, tech_short_title, tech_title_eng, tech_order) 
						VALUES (?, ?, ?, ?)";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$title, $tech_sort_title, $title_eng, $tech_order]);
		
		// Ενημέρωση log
		$section = "Χρήση Τεχνολογιών";
		$fld = "Προσθήκη νέας Τεχνολογίας";

		//Παίρνουμε από το σύστημα την ημέρα και ώρα
	  date_default_timezone_set('Europe/Athens');
    $date_of_update = date('Y/m/d h:i:s a', time());
		$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
						VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id'], $lesson_id, $section, $fld, "", $title]);

		
		header("Location: " . $_SERVER['PHP_SELF'] . "?lesson_id=" . $lesson_id . "#section-three");
	}
?>

<?php
	if(isset($_POST['new-ability'])){
		$lesson_id = $_POST['lesson-id'];
		$title = $_POST['ability-title'];
		$title_eng = $_POST['ability-title-eng'];

		$sql = "SELECT ability_short_title, ability_order FROM ability ORDER BY ability_order DESC LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetch();
		$ability_order = $results['ability_order'] +1;
		$ability_sort_title = "αλλο-" . $ability_order;

		$sql = "INSERT INTO ability (ability_title, ability_short_title, ability_title_eng, ability_order) 
						VALUES (?, ?, ?, ?)";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$title, $ability_sort_title, $title_eng, $ability_order]);
		
		// Ενημέρωση log
		$section = "Αποκτόμενες Ικανότητες";
		$fld = "Προσθήκη νέας Ικανότητας";
		$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
						VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id'], $lesson_id, $section, $fld, "", $title]);

		
		header("Location: " . $_SERVER['PHP_SELF'] . "?lesson_id=" . $lesson_id . "#section-two");
	}
?>



<?php
	if(isset($_POST['new-week-submit'])){
		$lesson_id = $_POST['lesson-id'];
		$week = $_POST['week-number'];
		$title = $_POST['week-title'];
		$book = $_POST['week-book'];
		$url = $_POST['week-url'];

		$section = "Εβδομαδιαίο Πρόγραμμα";
		$fld = "Προστέθηκε νέα εβδομάδα";
		$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
						VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id'], $lesson_id, $section, $fld, "", $week]);


		$sql = "INSERT INTO section2lesson (lesson_code, section, descr, reference, url) VALUES (?,?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_id, $week, $title, $book, $url]);

		header("Location: " . $_SERVER['PHP_SELF'] . "?lesson_id=" . $lesson_id . "#section-three");
	}
?>

<?php
	if(isset($_GET['delete_id'])){
		$delete_id = $_GET['delete_id'];
		$sql = "DELETE FROM lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delete_id]);
		header("Location: admin_courses.php");
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
          <div class="card shadow mb-3" id="section-one">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βασικές Πληροφορίες</h4>
          	</div>
          	<div class="card-body edit-lesson" id="basic-info">
							<form action="includes/handle_edit_lesson.php" method="POST" id="edit-lesson-form">
								<div class="form-row error-message error-edit-lesson">
									<div class="alert alert-danger" role="alert"></div>
								</div>
								<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>

								<div class="form-row">
									<div class="form-group col-md-7 required required-lesson-basic">
										<label for="title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
										<input type="text" name="title" id="title" class="font-weight-normal form-control" value="<?php echo $lesson['title']; ?>">
									</div>
									<div class="form-group col-md-3 required required-lesson-basic">
										<label for="ects" class="col-form-label font-weight-bold text-gray-800">Μονάδες ECTS:</label>
										<input type="text" name="ects" id="ects" class="font-weight-normal form-control" value="<?php echo $lesson['ects']; ?>">
									</div>
									<div class="form-group col-md-2 required required-lesson-basic">
										<label for="semester" class="col-form-label font-weight-bold text-gray-800">Εξάμηνο:</label>
										<input type="text" name="semester" id="semester" class="font-weight-normal form-control" value="<?php echo $lesson['semester']; ?>">
									</div>
								</div>

                <div class="form-row">
                  <div class="form-group col-md-6 required required-lesson-basic">
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
									<div class="form-group col-md-3 required required-lesson-basic">
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
									<div class="form-group col-md-3 required required-lesson-basic">
										<label for="language" class="col-form-label font-weight-bold text-gray-800">Γλώσσα Διδασκαλίας:</label>
										<input type="text" name="language" id="language" class="font-weight-normal form-control" value="<?php echo $lesson['lang']; ?>">
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-md-5 required required-lesson-basic">
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
									<div class="form-group col-md-3 required required-lesson-basic">
										<label for="erasmus" class="col-form-label font-weight-bold text-gray-800">Erasmus:</label>
										<input type="text" name="erasmus" id="erasmus" class="font-weight-normal form-control" value="<?php echo $lesson['erasmus']; ?>">
									</div>							
									<div class="form-group col-md-4">
										<label for="url" class="col-form-label font-weight-bold text-gray-800">URL:</label>
										<input type="text" name="url" id="url" class="font-weight-normal form-control" value="<?php echo $lesson['url']; ?>"> 
									</div>			
			        	</div>
								
								<div class="form-row">
									<div class="form-group col-md-8">
										<label for="title-eng" class="col-form-label font-weight-bold text-gray-800">Τίτλος(EN):</label>
										<input type="text" name="title-eng" id="title-eng" class="font-weight-normal form-control" value="<?php echo $lesson['title_eng']; ?>">
									</div>
									<div class="form-group col-md-4">
										<label for="language-eng" class="col-form-label font-weight-bold text-gray-800">Γλώσσα Διδασκαλίας(EN):</label>
										<input type="text" name="language-eng" id="language-eng" class="font-weight-normal form-control" value="<?php echo $lesson['lang_en']; ?>">
									</div>
								</div>

								<div class="form-group">	
									<label for="teaching-methods" class="col-form-label font-weight-bold text-gray-800">Διδακτικές Δραστηριότητες:</label>
									<textarea class="form-control" name="teaching-methods" id="teaching-methods" cols="80" rows="5"><?php echo $lesson['teaching_method'] != Null? trim($lesson['teaching_method']): "-"; 
									?></textarea>
								</div>
								<div class="form-group">	
									<label for="teaching-methods-eng" class="col-form-label font-weight-bold text-gray-800">Διδακτικές Δραστηριότητες(EN):</label>
									<textarea class="form-control" name="teaching-methods-eng" id="teaching-methods-eng" cols="80" rows="5"><?php echo $lesson['teaching_method_eng'] != Null? trim($lesson['teaching_method_eng']): "-"; 
									?></textarea>
								</div>
								<div class="form-group">
									<label for="curriculum" class="col-form-label font-weight-bold text-gray-800">Περιεχόμενα:</label>
									<textarea class="form-control" name="curriculum" id="curriculum" cols="80" rows="5"><?php echo $lesson['curriculum']; ?></textarea>
								</div>
								<div class="form-group">
									<label for="curriculum" class="col-form-label font-weight-bold text-gray-800">Περιεχόμενα(ΕΝ):</label>
									<textarea class="form-control" name="curriculum-eng" id="curriculum-eng" cols="80" rows="5"><?php echo $lesson['curriculum_eng']; ?></textarea>
								</div>
								
								<div class="form-group">
									<label for="grade-method" class="font-weight-bold text-gray-800 col-form-label">Αξιολόγηση:</label>
									<textarea class="form-control" name="grade-method" id="grade-method" cols="80" rows="5"><?php echo str_replace('\%', '%', trim($lesson['grade_method'])); 
									?></textarea>
								</div>
								<div class="form-row error-message error-lesson">
									<div class="alert alert-danger" role="alert">
  									Σφάλμα: Το μάθημα υπάρχει ήδη στη λίστα
									</div>
								</div>
								<div class="form-row">
									<label for="grade-method" class="font-weight-bold text-gray-800 col-form-label">Προαπαιτούμενα:</label>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<select class="form-control" name="prereq_lesson" id="prereq_lesson">
											<?php 
												// Όλα τα μαθήματα
												$sql = "SELECT lesson_code, title FROM lesson";
												$stmt = $pdo->prepare($sql);
												$stmt->execute();
												$courses = $stmt->fetchAll();

												foreach($courses as $course){
													if($course['lesson_code'] != $lesson['lesson_code'])
														echo "<option value={$course['lesson_code']}>{$course['title']}</option>";
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
									<h5 class="font-weight-bold text-gray-800">ΟΜΑΔΑ Α</h5>
										<ul id='alpha_team' class='list-group team_lists'>
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
									<h5 class="font-weight-bold text-gray-800">ΟΜΑΔΑ Β</h5>
										<ul id='beta_team' class='list-group team_lists'>
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
								<div class="form-row">
									<div class="form-group mb-3">
										<div class="lesson-category font-weight-bold 		text-gray-800">Προαπαιτούμενα: 
											<div class="font-weight-normal" id="prerequired-courses">
												<span id="group-a"></span>
												<span id="group-b"></span>
									
											</div>
										</div>
			        		</div>
								</div>
								<div class="form-row">
									<p></p>
								</div>
								<button type="submit" name="basic-info-update" class="btn btn-primary float-right">Ενημέρωση Πληροφοριών</button>
								<input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
              </form>
			      </div>
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
						<?php
											$sql = "SELECT * FROM lesson WHERE lesson_code = ?";
											$stmt = $pdo->prepare($sql);
											$stmt->execute([$lesson_id]);
											$lesson = $stmt->fetch();
										?>
							<div class="tab-content" id="pills-tabContent">
																<!-- Μαθησιακά αποτελέσματα -->
																<div class="tab-pane fade show active" id="pills-profile" role="tabpanel">
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
													if($lesson["aims"] != ""){
														$aims = explode("item", $lesson['aims']);
													
														foreach($aims as $aim){
															if ($aim != ""){
																echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $aim;
																echo "<textarea type='text' name='course_results[]' hidden>{$aim}</textarea>";
																echo "<i class='fas fa-trash-alt delete-item ml-3'></i>";
																echo "</li>";
															}														
														}
													}	
												?>
											</ul>
											<button type="submit" name="update-course-results" class="btn btn-primary float-right mt-3">Ενημέρωση Μαθησιακών Αποτελεσμάτων</button>
										</form>	
									</div>
								</div>
												
								<!-- Γενικές Ικανότητες που καλλιεργεί το μάθημα -->
								<div class="tab-pane fade" id="pills-home" role="tabpanel">
									<div class=" py-3">
										<p>
											<a class="btn btn-primary" data-toggle="collapse" href="#newAbility" role="button" aria-expanded="false" aria-controls="newAbility">
												Προσθήκη Αποκτόμενης Ικανότητας
											</a>
										</p>
										<div class="collapse" id="newAbility">
											<div class="card card-body">
												<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-ablt-form">
													<input type="text" name="lesson-id" value=<?php echo $lesson['lesson_code']; ?> hidden>
													<div class="form-row error-message error-new-ability">
														<div class="alert alert-danger" role="alert">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label for="ability-title-eng" class="font-weight-bold text-gray-800 col-form-label">Τίτλος:</label>
															<input type="text" class="form-control" name="ability-title" id="ability-title">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label for="ability-title-eng" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Ενότητας (ΕΝ):</label>
															<input type="text" class="form-control" name="ability-title-eng" id="ability-title-eng">
														</div>
													</div>
													<div class="form-group">
														<input type="submit" id="new-ability-submit" class="btn btn-success float-right" name="new-ability">
													</div>
												</form>
											</div>
										</div>
        					</div>
									<form method="POST" action="includes/handle_edit_lesson.php" id="edit-lesson-abilities">
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
												<input type="checkbox" class="custom-control-input abilities-checkbox" name="ability[]" id="customCheck<?php echo $row_count; ?>"
															value="<?php echo $row['ability_short_title'];?>" <?php echo is_null($row['lesson_code'])?:'checked' ?> >
										
													<label class="custom-control-label" for="customCheck<?= $row_count; ?>">
														<?= $row['ability_title']; ?>
													</label>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<button type="submit" name="update-abilities" class="btn btn-primary float-right">Ενημέρωση Ικανοτήτων</button>
										<input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά" id="abilities-reset">
									</form>
								</div>

								<!-- Μέθοδοι αξιολόγησης -->
								<div class="tab-pane fade" id="pills-contact" role="tabpanel">
									<form method="POST" action="includes/handle_edit_lesson.php" id="edit-lesson-assessment">
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
												<input type="checkbox" class="custom-control-input assessment-checkbox" name="assessment[]" id="assessmentCheck<?php echo $row_count; ?>"
												value="<?php echo $row['assessment_short_title']; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?>></input>
												<label class="custom-control-label" for="assessmentCheck<?php echo $row_count; ?>">
												<?php echo $row['assessment_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<button type="submit" name="update-assessments-methods" class="btn btn-primary float-right">Ενημέρωση Μεθόδων Αξιολόγησης</button>
										<input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά" id="assessment-reset">
									</form>
								</div>
							</div>
						</div>	
					</div>

					<!-- Οργάνωση διδασκαλίας - Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών - Πρόγραμμα-->
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
								<!-- Εβδομαδιαίο πρόγραμμα μαθήματος -->
								<div class="tab-pane fade show active" id="pills-program" role="tabpanel">
									<div class=" py-3">
										<p>
											<a class="btn btn-primary" data-toggle="collapse" href="#newWeek" role="button" aria-expanded="false" aria-controls="newWeek">
												Προσθήκη νέας Εβδομάδας
											</a>
										</p>
										<div class="collapse" id="newWeek">
											<div class="card card-body">
												<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-week-schedule">
													<input type="text" name="lesson-id" value=<?php echo $lesson['lesson_code']; ?> hidden>
													<div class="form-row error-message error-new-schedule">
														<div class="alert alert-danger" role="alert">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-2 required  required-insert">
															<label for="week-number" class="font-weight-bold text-gray-800 col-form-label">Εβδομάδα:</label>
															<input type="text" class="form-control" name="week-number" id="week-number">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12 required  required-insert">
															<label for="week-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Ενότητας:</label>
															<input type="text" class="form-control" name="week-title" id="week-title">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label for="week-book" class="font-weight-bold text-gray-800 col-form-label">Βιβλιογραφία:</label>
															<input type="text" class="form-control" name="week-book" id="week-book">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label for="week-url" class="font-weight-bold text-gray-800 col-form-label">Σύνδεσμος Παρουσιάσης:</label>
															<input type="text" class="form-control" name="week-url" id="week-url">
														</div>
													</div>
													<div class="form-group">
														<input type="submit" class="btn btn-success float-right" name="new-week-submit">
													</div>
												</form>
											</div>
										</div>
        					</div>
									<?php
										$sql = "SELECT * FROM section2lesson WHERE lesson_code = ?";
										$stmt = $pdo->prepare($sql);
										$stmt->execute([$lesson_id]);
										$weeks = $stmt->fetchAll();
										$number_of_weeks = $stmt->rowCount();

										if($number_of_weeks != 0):
									?>
										<table class="table table-striped editTable">
											<thead class="table-primary">
												<tr>
													<th scope="col">Εβδ.</th>
													<th scope="col">Τίτλος Ενότητας</th>
													<th scope="col">Βιβλιογραφία</th>
													<th scope="col">Σύνδεσμος Παρουσίασης</th>
													<th scope="col" class='editField'>Τροποποίση</th>
													<th scope="col" class='editField'>Διαγραφή</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													
													foreach($weeks as $week): ?>
														<tr>
														<td class='editField'><?php echo $week['section'];?></td>
														<td class='editField'><?php echo $week['descr']; ?></td>
														<td class='editField'><?php echo $week['reference'];?></td>
														<td class='editField'><a href="<?php echo $week['url']; ?>">Διαλέξεις</a></td>
														<td class='editField'><a href="edit_section.php?lesson_id=<?php echo $lesson['lesson_code'];?>&week=<?php echo $week['section'];?>"><i class="far fa-edit text-warning"></i></a></td>
                        		<td class="editField"><a href="edit_section.php?delete=<?php echo $lesson['lesson_code'];?>&week=<?php echo $week['section'];?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τον συγκεκριμένο καθηγητή;')"><i class='fas fa-trash-alt delete-item'></i></td>
														</tr>
													
													<?php endforeach; ?>
											</tbody>
										</table>
									<?php else: ?>
										<p>Δεν έχει εισαχθει το εβδομαδαίο πρόγραμμα του μαθήματος</p>
									<?php endif; ?>
								</div>
								<!-- Οργάνωση διδασκαλίας -->
								<div class="tab-pane fade" id="pills-organize" role="tabpanel">
									<div class="row mb-3">
										<form action="includes/handle_edit_lesson.php" method="POST" id="update-teach-organize-form">
											<input type="text" name="lesson_code" value="<?php echo $lesson_id; ?>" hidden>
											<div class="form-row error-message error-update-teach-organize">
												<div class="alert alert-danger" role="alert">
												</div>
											</div>
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
														echo "<div class='form-group col-md-4 organize'>";
														echo "<label class='col-form-label font-weight-bold text-gray-800'>{$row['teaching_title']}</label>";
														echo "<input type='text' name='{$names[$cnt]}' class='font-weight-normal form-control organize-teaching' value='{$row['hours']}'>";
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
													echo "<span class='font-weight-bold right' id='total-hours'>" . $total_hours . " ώρες</span>";
													
											?>	
											<button type="submit" name="update-organize-teaching" class="btn btn-primary float-right">Ενημέρωση Οργάνωσης Διδασκαλίας</button>
											<input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά" id="organize-reset-btn">
										</form>
									</div>
								</div>

								<!-- Χρήση Τεχνολογιών Πληροφορίας και Επικοινωνιών -->
								<div class="tab-pane fade" id="pills-tech" role="tabpanel">
									<div class=" py-3">
										<p>
											<a class="btn btn-primary" data-toggle="collapse" href="#newWeek" role="button" aria-expanded="false" aria-controls="newWeek">
												Προσθήκη Τεχνολογίας
											</a>
										</p>
										<div class="collapse" id="newWeek">
											<div class="card card-body">
												<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-tech-form">
													<input type="text" name="lesson-id" value=<?php echo $lesson['lesson_code']; ?> hidden>
													<div class="form-row error-message error-new-tech">
														<div class="alert alert-danger" role="alert">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12 required required-tech">
															<label for="tech-title-eng" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Ενότητας:</label>
															<input type="text" class="form-control" name="tech-title" id="tech-title">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label for="tech-title-eng" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Ενότητας (ΕΝ):</label>
															<input type="text" class="form-control" name="tech-title-eng" id="tech-title-eng">
														</div>
													</div>
													<div class="form-group">
														<input type="submit" id="new-tech-submit" class="btn btn-success float-right" name="new-tech">
													</div>
												</form>
											</div>
										</div>
        					</div>
									<form method="POST" action="includes/handle_edit_lesson.php" id="edit-lesson-tech">
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
												<input type="checkbox" class="custom-control-input tech-checkbox" name="tech[]" id="techCheck<?= $row_count; ?>"
												value="<?php echo $row['tech_short_title']; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?>></input>
												<label class="custom-control-label" for="techCheck<?= $row_count; ?>">
												<?= $row['tech_title']; ?>
											</div>
											<?php $row_count++; endwhile; ?>
										</div>
										<button type="submit" name="update-tech-methods" class="btn btn-primary float-right">Ενημέρωση Τεχνολογιών</button>
										<input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά" id="tech-reset">
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
							<div class="form-row error-message error-bibliography">
								<div class="alert alert-danger" role="alert">
  								Σφάλμα: Το βιβλίο υπάρχει ήδη στη λίστα
								</div>
							</div>
          		<div class="row mb-3">
								<form method="POST" action="includes/handle_edit_lesson.php">
									<input type="text" name="lesson-code" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" hidden>
									<div class="form-row">	
										<div class="form-group col-md-10">
                    	<select class="form-control" name="insert_bibliography" id="insert_bibliography">
												<?php 
													// Κατηγορία μαθήματος
													$sql = "SELECT * FROM book ORDER BY title";
													$stmt = $pdo->prepare($sql);
													$stmt->execute();
													$bibliography = $stmt->fetchAll();

													foreach($bibliography as $bibl_book){
														echo "<option value={$bibl_book['id']}>
															{$bibl_book['title']} {$bibl_book['authors']} {$bibl_book['publisher']} {$bibl_book['year']} {$bibl_book['eudoxus_id']} 
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
									<button type="submit" name="update-books" class="btn btn-primary float-right mt-3">Ενημέρωση Βιβλιογραφίας</button>
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
<!-- <script src="js/main.js"></script> -->
