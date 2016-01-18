<style type="text/css" class="slidersEverywhereStyle">


{foreach from=$configuration key=hook item=conf name=config}
	.SEslider.{$hook} {ldelim}
		padding:{$conf.media.max.tspace}px {$conf.media.max.rspace}px {$conf.media.max.bspace}px {$conf.media.max.lspace}px;
		width:{$conf.media.max.swidth}%;
		{if $conf.media.max.pos > 0}
			{if $conf.media.max.pos == 1}clear:both;{/if}
			{if $conf.media.max.pos == 1}float:left;{/if}
			{if $conf.media.max.pos == 2}margin:0 auto;clear:both;{/if}
			{if $conf.media.max.pos == 3}float:right;{/if}
		{/if}
	{rdelim}

	.SEslider.{$hook} .slidetitle {ldelim}
		background:{$conf.color.titlebg};
		color:{$conf.color.titlec};
	{rdelim}

	.SEslider.{$hook} .slide_description {ldelim}
		background:{$conf.color.descbg};
		color:{$conf.color.descc};
	{rdelim}

	.SEslider.{$hook} .se-next, .SEslider.{$hook} .se-prev {ldelim}
		background:{$conf.color.arrowbg};
		color:{$conf.color.arrowc};
	{rdelim}

	.SEslider.{$hook} .se-next:hover, .SEslider.{$hook} .se-prev:hover {ldelim}
		text-shadow:{$conf.color.arrowg};
	{rdelim}
	
	.SEslider.{$hook} .se-pager-item {ldelim}
		border-color:{$conf.color.pagerbc};
	{rdelim}
	
	.SEslider.{$hook} .se-pager-item:hover {ldelim}
		border-color:{$conf.color.pagerhbc};
		box-shadow:0 0 3px {$conf.color.pagerhg};
	{rdelim}
	
	.SEslider.{$hook} .se-pager a {ldelim}
		background-color:{$conf.color.pagerc};
	{rdelim}
	
	.SEslider.{$hook} .se-pager a.se-pager-link.active {ldelim}
		background-color:{$conf.color.pagerac};
	{rdelim}
	
	/** media queries **/

	{foreach from=$conf.media key=size item=value}
		{if $size != 'max'} 
			@media all and (max-width: {$size}px) {
				.SEslider.{$hook} {ldelim}
					padding:{$value.tspace}px {$value.rspace}px {$value.bspace}px {$value.lspace}px;
					width:{$value.swidth}%;
					{if $value.pos > 0}
						{if $value.pos == 1}float:left;{/if}
						{if $value.pos == 2}margin:0 auto;{/if}
						{if $value.pos == 3}float:right;{/if}
					{/if}
				{rdelim}
			}
		{/if}
	{/foreach}


{/foreach}

/** rtl **/

{if $rtlslide}
.SEslider, .SEslider * {ldelim}
  direction: ltr !important;
{rdelim}

.SEslider .slidetitle, .SEslider .slide_description {ldelim}
  direction: rtl !important;
{rdelim}

.SEslider .areaslide.block.transparent .areabuttcont {ldelim}
	text-align:right;
{rdelim}

{/if}

</style>