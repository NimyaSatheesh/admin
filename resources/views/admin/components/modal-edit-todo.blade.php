<div class="modal fade" id="editTodoModal{{ $todo->id }}" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createTaskLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

                <form action="{{ route('admin.todo.update', $todo->id) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')


                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Task Name</label>
                            <input type="text" name="task_name" class="form-control" value="{{ $todo->task_name }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assign To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $todo->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control"
                                value="{{ $todo->due_date }}"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="low" {{ $todo->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $todo->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $todo->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $todo->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ $todo->status == 'in-progress' ? 'selected' : '' }}>In-progress</option>
                                <option value="completed" {{ $todo->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
    </div>
    </div>

</div>
