 <h1>hello</h1>
    <div class="container">
        <h1>Projects</h1>

        <!-- Filter form -->
        <form method="GET" action="{{ url('projects/filter') }}">
            <div class="form-group">
                <label for="due_date">Filter by Due Date:</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ request('due_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <h2 class="mt-4">All Projects</h2>
        <ul class="list-group mt-3">
            @foreach ($projects as $project)
                <li class="list-group-item">
                    <h3>{{ $project->name }}</h3>
                    <p>{{ $project->description }}</p>
                    <p><strong>Due Date:</strong> {{ $project->due_date }}</p>
                    <p><strong>Created At:</strong> {{ $project->created_at }}</p>
                </li>
            @endforeach
        </ul>
    </div>
