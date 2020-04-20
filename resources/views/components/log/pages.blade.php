<div class="container marginadmin">
    <div class="row " >
        <div class="col-md-12 table-responsive marginadmin" >
            <h1 class="text-center"> Authorized pages log </h1>
            <table class="table mt-4">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Atacker IP address </th>
                </tr>
                </thead>
                <tbody id="tableLog">
                @for($f = $first_ips;  $f < count($filePages);  $f++ )
                    @if($f < $last_ips )
                        <tr>
                            <td> {{ $f+1}} </td>
                            <td> {{ $filePages[$f] }} </td>
                        </tr>
                    @endif
                @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center m-5">
            <div class="block-27" id="pagLogAdmin" >
                <ul>
                    @for($i = 0; $i < ceil(count($filePages) / $per_page); $i++)
                        <li ><a class="pagination_link"  data-value="{{ $i+1 }}" href="{{ route('logs' , ['id' => $i+1]) }}"> {{ $i+1 }} </a></li>
                    @endfor
                </ul>

            </div>
        </div>
    </div>
</div>
