function h(t)
{
	if(typeof last == "undefined")
		last=document.anchors[0];
		
	last.className='n';
	t.className='nh';
	t.blur();
	last=t;
}
