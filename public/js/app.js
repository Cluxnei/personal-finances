$(() => {
    const renderGraph = (elementId, labels, datasets, type = 'pie') => {
        const ctx = document.getElementById(elementId).getContext('2d');
        new Chart(ctx, {
            type,
            data: {
                labels,
                datasets,
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    };
    const randomColor = () => '#' + Math.floor(Math.random() * 16777215).toString(16);
    const colorsByKey = {};
    const randomColorForKey = (key) => {
        if (!colorsByKey[key]) {
            colorsByKey[key] = randomColor();
        }
        return colorsByKey[key];
    };

    const inflowsCategories = JSON.parse($('meta[name="inflows-categories"]').attr('content')) || {};
    const outflowsCategories = JSON.parse($('meta[name="outflows-categories"]').attr('content')) || {};
    const inflowsVsOutflows = JSON.parse($('meta[name="inflows-vs-outflows"]').attr('content')) || {};
    const inflowsPerDay = JSON.parse($('meta[name="inflows-per-day"]').attr('content')) || {};
    const outflowsPerDay = JSON.parse($('meta[name="outflows-per-day"]').attr('content')) || {};

    renderGraph('inflowsPiePerCategory', Object.keys(inflowsCategories), [{
        label: 'Inflows per category',
        data: Object.keys(inflowsCategories).map(key => inflowsCategories[key]),
        backgroundColor: Object.keys(inflowsCategories).map(key => randomColorForKey(key)),
    }]);

    renderGraph('outflowsPiePerCategory', Object.keys(outflowsCategories), [{
        label: 'Outflows per category',
        data: Object.keys(outflowsCategories).map(key => outflowsCategories[key]),
        backgroundColor: Object.keys(outflowsCategories).map(key => randomColorForKey(key)),
    }]);

    renderGraph('inflowsVsOutflowsPie', Object.keys(inflowsVsOutflows), [{
        label: 'Inflows vs Outflows',
        data: Object.keys(inflowsVsOutflows).map(key => inflowsVsOutflows[key]),
        backgroundColor: Object.keys(inflowsVsOutflows).map(key => randomColorForKey(key)),
    }]);


    const inflowsVsOutflowsPerDayLabels = [...Object.keys(inflowsPerDay), ...Object.keys(outflowsPerDay)];
    inflowsVsOutflowsPerDayLabels.sort((a, b) => a.localeCompare(b));
    renderGraph('inflowsVsOutflowsPerDayLine', inflowsVsOutflowsPerDayLabels, [
        {
            label: 'Inflows per day',
            data: inflowsVsOutflowsPerDayLabels.map(day => inflowsPerDay[day] || 0),
            backgroundColor: 'rgb(75, 192, 192)',
        },
        {
            label: 'Outflows per day',
            data: inflowsVsOutflowsPerDayLabels.map(day => outflowsPerDay[day] || 0),
            backgroundColor: 'rgb(255, 50, 100)',
        },
    ], 'line');
});
