<?= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL ?>
<rss version="2.0"
     xmlns:media="http://search.yahoo.com/mrss/">

    <channel>
        <title><![CDATA[{{ $config->app_name }}]]></title>
        <link><![CDATA[{{ url('feed') }}]]></link>
        <description><![CDATA[{{ $config->information }}]]></description>
        <language>pt-br</language>
        <pubDate>{{ now()->toRssString() }}</pubDate>

        @foreach($noticias as $noticia)
            <item>
                <title><![CDATA[{{ $noticia->title }}]]></title>

                <link>{{ route('web.blog.noticia', ['slug' => $noticia->slug]) }}</link>

                <guid isPermaLink="true">
                    {{ route('web.blog.noticia', ['slug' => $noticia->slug]) }}
                </guid>

                <pubDate>{{ $noticia->created_at->toRssString() }}</pubDate>

                <description><![CDATA[{!! $noticia->getContentWebAttribute() !!}]]></description>

                <category><![CDATA[{{ $noticia->categoryObject->title }}]]></category>

                <author><![CDATA[{{ $noticia->userObject->name }}]]></author>

                @if($noticia->cover())
                    <media:content url="{{ $noticia->cover() }}" medium="image" />
                    <enclosure url="{{ $noticia->cover() }}" type="image/jpeg" />
                @endif
            </item>
        @endforeach

        @foreach($artigos as $artigo)
            <item>
                <title><![CDATA[{{ $artigo->title }}]]></title>

                <link>{{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}</link>

                <guid isPermaLink="true">
                    {{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}
                </guid>

                <pubDate>{{ $artigo->created_at->toRssString() }}</pubDate>

                <description><![CDATA[{!! $artigo->getContentWebAttribute() !!}]]></description>

                <category><![CDATA[{{ $artigo->categoryObject->title }}]]></category>

                <author><![CDATA[{{ $artigo->userObject->name }}]]></author>

                @if($artigo->cover())
                    <media:content url="{{ $artigo->cover() }}" medium="image" />
                    <enclosure url="{{ $artigo->cover() }}" type="image/jpeg" />
                @endif
            </item>
        @endforeach

        @foreach($imoveis as $imovel)
            <item>
                <title><![CDATA[{{ $imovel->title }}]]></title>

                <link>{{ route('web.property', ['slug' => $imovel->slug]) }}</link>

                <guid isPermaLink="true">
                    {{ route('web.property', ['slug' => $imovel->slug]) }}
                </guid>

                <pubDate>{{ $imovel->created_at->toRssString() }}</pubDate>

                <description><![CDATA[{!! $imovel->getContentWebAttribute() !!}]]></description>

                <category><![CDATA[{{ $imovel->category }} - {{ $imovel->type }}]]></category>

                <author><![CDATA[{{ $config->app_name }}]]></author>

                @if($imovel->cover())
                    <media:content url="{{ $imovel->cover() }}" medium="image" />
                    <enclosure url="{{ $imovel->cover() }}" type="image/jpeg" />
                @endif
            </item>
        @endforeach

    </channel>
</rss>