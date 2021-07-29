function pick(answer, id)
{
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>materiSoal/saveAnswer',
		data:
		{
			id: id,
			answer: answer,
		}
	})
}