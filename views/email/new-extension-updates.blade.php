{!! $translator->trans('extiverse-mercury.email.new-extension-update.body', [
'{recipient_display_name}' => $user->display_name,
'{count}' => $blueprint->updates->count(),
'{extensions}' => $blueprint->updates->pluck('name')->implode(', '),
'{url}' => $url->to('admin')->route('index') . '#/extension/extiverse-mercury'
]) !!}
