<tr data-id="{{ $menu->id }}" data-parent-id="{{ $menu->parent_id }}" class="@if($level > 0) menu-level-{{ $level }} @endif">
    <td>{{ $menu->id }}</td>
    <td>
        @for($i = 0; $i < $level; $i++)
            <span style="margin-left: 20px;">└─</span>
        @endfor
        @if($menu->icon)
            <i class="{{ $menu->icon }}"></i>
        @endif
        {{ $menu->name }}
    </td>
    <td>
        <code>{{ $menu->slug }}</code>
    </td>
    <td>
        @if($menu->url)
            <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="text-primary">
                {{ Str::limit($menu->url, 50) }}
            </a>
        @else
            <span class="text-muted">—</span>
        @endif
    </td>
    <td>
        <span class="badge badge-{{ $menu->position === 'header' ? 'primary' : ($menu->position === 'footer' ? 'secondary' : 'info') }}">
            {{ ucfirst($menu->position) }}
        </span>
    </td>
    <td>
        <span class="badge badge-light">{{ $menu->sort_order }}</span>
    </td>
    <td>
        <a href="{{ route('admin.menus.toggle-status', $menu) }}" class="toggle-status">
            @if($menu->status === 'active')
                <span class="badge badge-success">
                    <i class="fas fa-check-circle"></i> Hoạt động
                </span>
            @else
                <span class="badge badge-danger">
                    <i class="fas fa-times-circle"></i> Vô hiệu
                </span>
            @endif
        </a>
    </td>
    <td>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.menus.show', $menu) }}" 
               class="btn btn-info btn-sm" title="Xem">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('admin.menus.edit', $menu) }}" 
               class="btn btn-warning btn-sm" title="Sửa">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.menus.destroy', $menu) }}" 
                  method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger btn-sm delete-menu" title="Xóa">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>

@foreach($menu->children as $child)
    @include('admin.menus.partials.menu-row', ['menu' => $child, 'level' => $level + 1])
@endforeach