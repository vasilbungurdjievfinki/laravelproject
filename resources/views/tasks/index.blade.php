 <div class="container">
        <h1>Tasks</h1>

        <!-- Filter form -->
        <form method="GET" action="{{ url('tasks') }}">
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <h2 class="mt-4">All Tasks</h2>
        <ul class="list-group mt-3">
            @foreach ($tasks as $task)
                <li class="list-group-item">
                    <h3>{{ $task->title }}</h3>
                    <p>{{ $task->description }}</p>
                    <p><strong>Category:</strong> {{ $task->category->name }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
                    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>

                    @if ($task->status != 'completed')
                        <form method="POST" action="{{ route('tasks.complete', $task->id) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Mark as Completed</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
