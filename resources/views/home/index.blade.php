@extends('layouts.admin')
@section('content')
    <div class="card">
                @if($create)
                    <a href="{{route('add')}}" class="btn btn-success">Add</a>
                @endif
                <div class="card-header">Blog Listesi</div>
                <div class="card-body">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>User</th>
                            <th>View</th>
                            <th>Vote</th>
                            <th>Publish</th>
                            <th>Process</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blogs as $bl) { ?>
                            <tr>
                                <td><?=$bl['id']?></td>
                                <td><?=$bl['title']?></td>
                                <td><?=$bl['user']?></td>
                                <td><?=$bl['view']?></td>
                                <td><?=$bl['vote']?></td>
                                <td>
                                    @if($bl['publish'] == 1)
                                    <span class="alert alert-success">Yayında</span>
                                    @else
                                        <span class="alert alert-danger">Yayında Değil</span>
                                    @endif
                                </td>
                                <td>
                                    <?=$bl['actions']?>
                                </td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>
@endsection
      