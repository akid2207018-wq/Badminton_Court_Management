@if ($paginator->hasPages())
    <nav style="display:flex;justify-content:center;margin-top:16px;">
        <ul style="list-style:none;display:flex;gap:4px;padding:0;margin:0;">

            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display:inline-block;padding:6px 12px;border:1px solid #dde3ea;
                                 border-radius:4px;font-size:13px;color:#bbb;background:#f8f9fa;">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       style="display:inline-block;padding:6px 12px;border:1px solid #dde3ea;
                              border-radius:4px;font-size:13px;color:#2c7be5;background:#fff;
                              text-decoration:none;">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span style="display:inline-block;padding:6px 10px;font-size:13px;color:#888;">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display:inline-block;padding:6px 12px;border:1px solid #2c7be5;
                                             border-radius:4px;font-size:13px;color:#fff;background:#2c7be5;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   style="display:inline-block;padding:6px 12px;border:1px solid #dde3ea;
                                          border-radius:4px;font-size:13px;color:#2c7be5;background:#fff;
                                          text-decoration:none;">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       style="display:inline-block;padding:6px 12px;border:1px solid #dde3ea;
                              border-radius:4px;font-size:13px;color:#2c7be5;background:#fff;
                              text-decoration:none;">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span style="display:inline-block;padding:6px 12px;border:1px solid #dde3ea;
                                 border-radius:4px;font-size:13px;color:#bbb;background:#f8f9fa;">
                        &raquo;
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
