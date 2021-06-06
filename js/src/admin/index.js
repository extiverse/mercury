import app from 'flarum/app';

import HeaderSecondary from './extend/HeaderSecondary';

app.initializers.add('extiverse-mercury', () => {
    const link = "https://extiverse.com/auth/mercury?community=" + window.location.host;

    app.extensionData
        .for('extiverse-mercury')
        .registerSetting({
            setting: 'extiverse-mercury.token',
            type: 'text',
            label: app.translator.trans('extiverse-mercury.admin.settings.token', {a: <a href={link} target="_blank" />})
        });

    HeaderSecondary();
});
