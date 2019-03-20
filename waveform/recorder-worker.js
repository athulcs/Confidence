var RecorderWorker = function() {
    function a() {}
    return a.prototype.toString = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
        return "importScripts('" + e.origin + "/v2/js/lame.min.js'); \n                self.onmessage = " + function(e) {
            switch (e.data.type) {
                case "saveStream":
                    var a = Math.floor(e.data.from * self.numFramesInSecond),
                        r = Math.ceil(e.data.to * self.numFramesInSecond) + 1,
                        s = new Blob(self.recordBuffer.slice(a, r));
                    self.postMessage({
                        handlerId: e.data.handlerId,
                        url: URL.createObjectURL(s, {
                            type: "audio/mp3"
                        }),
                        type: "saveStream"
                    });
                    break;
                case "appendData":
                    self.record && (self.getMinAndMaxSamples(e.data.data), self.minAndMaxSamples.push(self.floatTo16BitPCM(e.data.data)), self.encode(self.floatTo16BitPCM(e.data.data)));
                    break;
                case "init":
                    self.sampleRate = e.data.sampleRate || 44100, self.bufferSize = e.data.bufferSize || 2048, self.minAndMaxSamples = [], self.recordBuffer = [], self.maxSamples = 2304, self.encoder = new lamejs.Mp3Encoder(1, self.sampleRate, 256), self.record = !1, self.postMessage({
                        type: "init"
                    });
                    break;
                case "startRecord":
                    self.record = !self.record, self.postMessage({
                        handlerId: e.data.handlerId,
                        type: "startRecord",
                        record: self.record
                    });
                    break;
                case "stopRecord":
                    self.record = !self.record, self.recordBuffer.push(self.encoder.flush()), self.duration = self.recordBuffer.length * self.bufferSize / self.sampleRate, self.numFramesInSecond = self.recordBuffer.length / self.duration, self.postMessage({
                        handlerId: e.data.handlerId,
                        type: "stopRecord",
                        record: self.record,
                        samplesData: self.minAndMaxSamples,
                        time: Date.now(),
                        duration: self.duration,
                        numFramesInSecond: self.numFramesInSecond,
                        url: URL.createObjectURL(new Blob(self.recordBuffer, {
                            type: "audio/mp3"
                        }))
                    });
                    break;
                case "reset":
                    self.recordBuffer = [], self.minAndMaxSamples = [], self.record = !1
            }
        } + "; \n                self.params = " + JSON.stringify(e) + "; \n                self.encode=" + function(e) {
            for (var a = e.length, r = 0; 0 <= a; r += self.maxSamples) {
                var s = e.subarray(r, r + self.maxSamples);
                self.recordBuffer.push(new Int8Array(self.encoder.encodeBuffer(s))), a -= self.maxSamples
            }
        } + "; \n                self.getMinAndMaxSamples=" + function(e) {
            for (var a = {
                    min: 1,
                    max: -1
                }, r = 0; r < e.length; r++) e[r] < a.min && (a.min = e[r]), e[r] > a.max && (a.max = e[r]);
            return a
        } + ";\n                self.floatTo16BitPCM=" + function(e) {
            for (var a = new Int16Array(e.length), r = 0; r < e.length; r++) {
                var s = Math.max(-1, Math.min(1, e[r]));
                a[r] = s < 0 ? 32768 * s : 32767 * s
            }
            return a
        }
    }, a.getInstance = function(e) {
        return (new a).toString(e)
    }, a
}();