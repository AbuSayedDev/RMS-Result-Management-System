<ul>
    <li title="Dashboard" class="sidebar_dashboard">
        <a href="{{ route('frontend_index') }}">
            <span class="menu_icon"><i class="material-icons">dashboard</i></span>
            <span class="menu_title">Dashboard</span>
        </a>
    </li>
    <li title="Students" class="sidebar_students">
        <a href="{{ route('admin_students_index') }}">
            <span class="menu_icon"><i class="material-icons">groups</i></span>
            <span class="menu_title">Students</span>
        </a>
    </li>
    <li title="Subjects" class="sidebar_subjects">
        <a href="{{ route('admin_subjects_index') }}">
            <span class="menu_icon"><i class="material-icons">auto_stories</i></span>
            <span class="menu_title">Subjects</span>
        </a>
    </li>
    <li title="Results" class="sidebar_results">
        <a href="{{ route('admin_results_index') }}">
            <span class="menu_icon"><i class="material-icons">confirmation_number</i></span>
            <span class="menu_title">Results</span>
        </a>
    </li>
</ul>