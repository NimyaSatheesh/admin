@extends('admin.layouts.app')

@section('content')

 <!-- Start here.... -->

 <div class="row">
    <div class="col">
         <div class="card">
              <div class="card-body">
                   <div class="d-flex flex-wrap justify-content-between gap-3">
                        <div class="search-bar">
                             <span><i class="bx bx-search-alt"></i></span>
                             <input type="search" class="form-control" id="search" placeholder="Search task...">
                        </div>
                        @hasanyrole('admin|super-admin')
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                <i class="bx bx-plus me-1"></i> Create Task
                            </button>
                        </div>
                        @endhasanyrole
                   </div> <!-- end row -->
              </div>
              <div>
                   <div class="table-responsive table-centered">
                        <table class="table text-nowrap mb-0">
                             <thead class="bg-light bg-opacity-50">
                                  <tr>
                                       <th class="border-0 py-2">Task Name</th>
                                       <th class="border-0 py-2">Created Date</th>
                                       <th class="border-0 py-2">Due Date</th>
                                       <th class="border-0 py-2">Assigned</th>
                                       <th class="border-0 py-2">Status</th>
                                       <th class="border-0 py-2">Priority</th>
                                       <th class="border-0 py-2">Action</th>
                                  </tr>
                             </thead> <!-- end thead-->
                             <tbody>
                                @foreach ($todos as $todo)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="form-check form-todo ps-4">
                                                    <input type="checkbox" class="form-check-input rounded-circle mt-0 fs-18">
                                                    <label class="form-check-label">
                                                        {{ $todo->task_name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                
                                        <td>
                                            {{ $todo->created_at->format('d M, Y') }}
                                            <small>{{ $todo->created_at->format('h:i A') }}</small>
                                        </td>
                                
                                        <td>{{ \Carbon\Carbon::parse($todo->due_date)->format('d M, Y') }}</td>
                                
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/images/default-avatar.png') }}" class="avatar-xs rounded-circle me-2">
                                                <div>
                                                    <h5 class="fs-14 m-0 fw-normal">
                                                        {{ $todo->assignedUser?->name ?? 'Unassigned' }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                
                                        <td>
                                            @if ($todo->status == 'pending')
                                                <span class="badge badge-soft-warning">Pending</span>
                                            @elseif ($todo->status == 'in-progress')
                                                <span class="badge badge-soft-info">In Progress</span>
                                            @else
                                                <span class="badge badge-soft-success">Completed</span>
                                            @endif
                                        </td>
                                
                                        <td class="{{ $todo->priority == 'high' ? 'text-danger' : ($todo->priority == 'medium' ? 'text-warning' : 'text-success') }}">
                                            <i class="bx bxs-circle me-1"></i>
                                            {{ ucfirst($todo->priority) }}
                                        </td>
                                        @hasanyrole('super-admin|admin')
                                        <td>
                                             <!-- Edit Button -->
                                            <button class="btn btn-sm btn-soft-secondary" data-bs-toggle="modal"
                                                data-bs-target="#editTodoModal{{ $todo->id }}">
                                                <i class="bx bx-edit"></i>
                                            </button>                                          
                                            <!-- Delete -->
                                            <form action="{{ route('admin.todo.delete', $todo->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-soft-danger" onclick="return confirm('Delete Task?')">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>                                        
                                        </td>
                                        @endhasanyrole
                                    </tr>
                                    @include('admin.components.modal-edit-todo', ['todo' => $todo, 'users' => $users])

                                @endforeach
                            </tbody>
                                 <!-- end tbody -->
                        </table> <!-- end table -->
                   </div> <!-- table responsive -->
                   <div class="align-items-center justify-content-between row g-0 text-center text-sm-start p-3 border-top">
                        <div class="col-sm">
                            <div class="text-muted">
                                Showing <span class="fw-semibold">10</span> of <span class="fw-semibold">52</span> tasks
                            </div>
                        </div>
                        <div class="col-sm-auto mt-3 mt-sm-0">
                            <ul class="pagination pagination-rounded m-0">
                                <li class="page-item">
                                    <a href="#" class="page-link"><i class='bx bx-left-arrow-alt'></i></a>
                                </li>
                                <li class="page-item active">
                                    <a href="#" class="page-link">1</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">3</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link"><i class='bx bx-right-arrow-alt'></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
</div> <!-- end row -->

@include('admin.components.modal-create-todo')

@endsection
