<div class="d-flex vh-100 justify-content-center align-items-center vh-100">
    <div class="container">
        <h1 class="mb-4">Project Meetings</h1>
        
        <!-- Create new meeting form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Schedule a New Meeting</h5>
            </div>
            <div class="card-body">
                <form action="/meetings" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Meeting Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Meeting Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="meeting_date" class="form-label">Date & Time</label>
                        <input type="datetime-local" class="form-control" id="meeting_date" name="meeting_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project</label>
                        <select class="form-select" id="project_id" name="project_id" required>
                            <?php if (isset($projects) && is_array($projects)): ?>
                                <?php foreach($projects as $project): ?>
                                    <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option>No projects available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Schedule Meeting</button>
                </form>
            </div>
        </div>
        
        <!-- Existing meetings -->
        <h2>Upcoming Meetings</h2>
        <?php if (isset($meetings) && is_array($meetings) && count($meetings) > 0): ?>
            <div class="list-group">
                <?php foreach($meetings as $meeting): ?>
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($meeting['title']) ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($meeting['subject']) ?></p>
                            <small><?= date('F j, Y, g:i a', strtotime($meeting['meeting_date'])) ?></small>
                        </div>
                        <div>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMeeting<?= $meeting['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form class="d-inline" method="POST" action="/meetings/delete">
                                <input type="hidden" name="id" value="<?= $meeting['id'] ?>">
                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this meeting?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editMeeting<?= $meeting['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Meeting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/meetings/update" method="POST">
                                        <input type="hidden" name="id" value="<?= $meeting['id'] ?>">
                                        <div class="mb-3">
                                            <label for="edit_title<?= $meeting['id'] ?>" class="form-label">Meeting Title</label>
                                            <input type="text" class="form-control" id="edit_title<?= $meeting['id'] ?>" 
                                                   name="title" value="<?= htmlspecialchars($meeting['title']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_subject<?= $meeting['id'] ?>" class="form-label">Meeting Subject</label>
                                            <input type="text" class="form-control" id="edit_subject<?= $meeting['id'] ?>" 
                                                   name="subject" value="<?= htmlspecialchars($meeting['subject']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_date<?= $meeting['id'] ?>" class="form-label">Date & Time</label>
                                            <input type="datetime-local" class="form-control" id="edit_date<?= $meeting['id'] ?>" 
                                                   name="meeting_date" value="<?= date('Y-m-d\TH:i', strtotime($meeting['meeting_date'])) ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Meeting</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No meetings scheduled yet.</p>
        <?php endif; ?>
    </div>
</div>
