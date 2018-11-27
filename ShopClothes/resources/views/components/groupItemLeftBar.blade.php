<li id="leftBarParent" class="nav-item">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-layers"></i>
        <span class="title">{{ $name }}</span>
        <span class="selected"></span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        @foreach( $child as $c )
            <li class="nav-item leftBarChild <?php if( $c['isCurrent'] ){ echo 'active open'; } ?>" parent="{{ $c['isCurrent'] }}">
                <a href="{{ $c['link'] }}" class="nav-link ">
                    <span class="title">{{ $c['name'] }}</span>
                    <span class="selected"></span>
                </a>
            </li>
        @endforeach
    </ul>
</li>